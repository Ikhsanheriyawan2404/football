<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Standing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class GameController extends Controller
{
    protected $winPoints = 3;
    protected $drawPoints = 1;

    public function index()
    {
        if (request()->ajax()) {
            $game = Game::with(['home', 'away'])->get();
            return DataTables::of($game)
                ->editColumn('home.name', function (Game $game) {
                    $html = '<p>'.$game->home->name.'</p>
                    <p>'.$game->home_score.'</p>';
                    return $html;
                })
                ->editColumn('away.name', function (Game $game) {
                    $html = '<p>'.$game->away->name.'</p>
                    <p>'.$game->away_score.'</p>';
                    return $html;
                })
                ->addIndexColumn()
                ->rawColumns(['home.name', 'away.name'])
                ->make(true);
        }


        return view('games.index', [
            'title' => 'List Pertandingan'
        ]);
    }

    public function store()
    {
        try {

            DB::transaction(function () {

                request()->validate([
                    'home_club_id' => 'required',
                    'away_club_id' => 'required',
                    // 'home_score' => 'required|numeric',
                    // 'away_score' => 'required|numeric',
                ]);

                $totalRequestItem = request('home_club_id');

                for ($i = 0; $i < count($totalRequestItem); $i++) {

                    $data = [
                        'home_club_id' => request('home_club_id')[$i],
                        'away_club_id' => request('away_club_id')[$i],
                        'home_score' => request('home_score')[$i],
                        'away_score' => request('away_score')[$i],
                    ];

                    if ($data['home_club_id'] == $data['away_club_id']) {
                        throw new \Exception('Klub Tidak Boleh Sama');
                    }

                    $existingGame = Game::where('home_club_id', $data['home_club_id'])
                    ->where('away_club_id', $data['away_club_id'])->first();

                    if ($existingGame) {
                        throw new \Exception('Pertandingag sudah ada');
                    }

                    $game = Game::create($data);

                    $homeClub = Standing::where('club_id', $game->home_club_id)->first();

                    if ($game->home_score > $game->away_score) {
                        $homeClub->increment('points', $this->winPoints);
                        $homeClub->increment('wins');
                    } elseif ($game->home_score == $game->away_score) {
                        $homeClub->increment('points', $this->drawPoints);
                        $homeClub->increment('draws');
                    } else {
                        $homeClub->increment('losses');
                    }

                    $homeClub->increment('goals_for', $game->home_score);
                    $homeClub->increment('goals_against', $game->away_score);

                    $awayClub = Standing::where('club_id', $game->away_club_id)->first();

                    if ($game->away_score > $game->home_score) {
                        $awayClub->increment('points', $this->winPoints);
                        $awayClub->increment('wins');
                    } elseif ($game->away_score == $game->home_score) {
                        $awayClub->increment('points', $this->drawPoints);
                        $awayClub->increment('draws');
                    } else {
                        $awayClub->increment('losses');
                    }

                    $awayClub->increment('goals_for', $game->away_score);
                    $awayClub->increment('goals_against', $game->home_score);

                    $awayClub->save();
                }
            });

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }

        return response()->json([
            'message' => 'Berhasil menabmah data baru'
        ]);
    }
}
