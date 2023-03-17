<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Standing;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ClubController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $club = Club::get();
            return DataTables::of($club)
                ->addIndexColumn()
                ->make(true);
        }


        return view('clubs.index', [
            'title' => 'List Klub   '
        ]);
    }

    public function data()
    {
        $clubs = Club::get(['id', 'name']);
        return response()->json($clubs);
    }

    public function create()
    {
        return view('clubs.create', [
            'title' => 'Tambah Klub'
        ]);
    }

    public function store()
    {
        try {
            request()->validate([
                'name' => 'required|unique:clubs,name',
                'city' => 'required',
            ]);

            $request = request()->all();

            $club = Club::create($request);

            Standing::create([
                'club_id' => $club->id,
                'wins' => 0,
                'draws' => 0,
                'losses' => 0,
                'points' => 0,
                'goals_for' => 0,
                'goals_against' => 0,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }

        return response()->json([
            'message' => 'Berhasil menabmah data baru'
        ]);
    }

    public function edit($id)
    {
        $club = Club::find($id);
        return response()->json($club);
    }
}
