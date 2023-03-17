<?php

namespace App\Http\Controllers;

use App\Models\Standing;
use Yajra\DataTables\Facades\DataTables;

class StandingController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $standingg = Standing::with('club')->get();
            return DataTables::of($standingg)
                ->addIndexColumn()
                ->make(true);
        }


        return view('welcome', [
            'title' => 'Klasemen Liga'
        ]);
    }
}
