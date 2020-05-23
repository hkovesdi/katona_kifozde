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

    public function modositas(Request $request)
    {
        $data = $request->all();

        foreach($data['megrendelesek'] as $nap => $tetelek) {
            foreach($tetelek as $tetelNev => $adagok) {
                //Check how many megrendeles exists and compute difference
                //Iff existing > proposed 
                    //Check If user has sufficient privileges
                //if proposed > existing
                    //Create the new records
            }
        }

        return 0;
    }

    private function getCurrentHet() {
        return Carbon::now()->weekOfYear;
    }
}
