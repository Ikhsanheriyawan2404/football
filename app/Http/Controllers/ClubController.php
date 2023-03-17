<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ClubController extends Controller
{
    public function index()
    {
        $clubs = Club::all();

        return view('clubs.index', compact('clubs'));
    }

    public function standings()
    {
        if (request()->ajax()) {
            $club = Club::get(['id', 'name', 'city']);
            return DataTables::of($club)
                ->addIndexColumn()
                ->make(true);
        }


        return view('welcome', [
            'title' => 'Klasemen Liga'
        ]);
    }
}
