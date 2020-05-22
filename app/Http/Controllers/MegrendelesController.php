<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MegrendelesController extends Controller
{
    public function show()
    {
        $megrendelok = \App\Megrendelo::where('kiszallito_id',Auth::user()->id)
            ->with(['megrendelesek' => function($query){
                $query->whereHas('tetel.datum', function($query){
                    $query->where(DB::raw("WEEK(`datum`)"), $this->getCurrentHet());
                })->with('tetel.datum');
            }])
            ->get();
            //->toArray(); 

        $data = [
            'megrendelok' => $megrendelok,
            'het' => $this->getCurrentHet(),
            'tetelek' => \App\TetelNev::all(),
        ];

        return view('megrendelesek', $data);
    }

    private function getCurrentHet() {
        return Carbon::now()->weekOfYear;
    }
}
