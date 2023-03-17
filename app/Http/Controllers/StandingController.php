<?php

namespace App\Http\Controllers;

use App\Models\Standing;
use Yajra\DataTables\Facades\DataTables;

class StandingController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $standing = Standing::with('club')
                ->orderBy('points', 'desc')
                ->orderBy('goals_for', 'desc')
                ->get();

            return DataTables::of($standing)
                ->addIndexColumn()
                ->addColumn('selisih_goal', function (Standing $standing) {
                    return $standing->goals_for - $standing->goals_against;
                })
                ->editColumn('plays', function (Standing $standing) {
                    return $standing->awayGames->count() + $standing->homeGames->count();
                })
                ->make(true);
        }


        return view('welcome', [
            'title' => 'Klasemen Liga'
        ]);
    }
}
