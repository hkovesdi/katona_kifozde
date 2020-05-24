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
        $megrendelok = \App\Megrendelo::when(Auth::user()->munkakor == "Kiszállító", function($query){
            return $query->where('kiszallito_id',Auth::user()->id);
        })
            ->with(['megrendelesek' => function($query){
                $query->whereHas('tetel.datum', function($query){
                    $query->where(DB::raw("WEEK(datum,1)"), $this->getCurrentHet())
                        ->whereYear('datum', Carbon::now()->year);
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


        $megrendelo = \App\Megrendelo::when(Auth::user()->munkakor == "Kiszállító", function($query){
            return $query->where('kiszallito_id',Auth::user()->id);
        })
        ->with(['megrendelesek' => function($query){
            $query
                ->whereHas('tetel.datum', function($query){
                    $query->where(DB::raw("WEEK(datum,1)"), $this->getCurrentHet())
                        ->whereYear('datum', Carbon::now()->year);
                })->with('tetel.datum');
        }])
        ->whereHas('megrendelesek', function($query) use($data){
            $query->where('megrendelo_id', $data['megrendelo-id']);
        })
        ->first();

        $weekstart = Carbon::create(Carbon::now()->year,1,1)->nthOfYear($this->getCurrentHet(),Carbon::MONDAY)->format('Y-m-d');
        $megrendelesekC = count($megrendelo->megrendelesek);

        foreach($data['megrendelesek'] as $nap => $tetelek) {
            foreach($tetelek as $tetel => $adagok) {

                $tetelNev = \App\TetelNev::where('nev', $tetel)->first();

                $currentMegrendelesek = $megrendelo->megrendelesek
                    ->where('tetel.tetel_nev', $tetelNev->nev)
                    ->where('day_of_week', $nap+1);
                if(count($currentMegrendelesek) > 0)
                {
                    $test = "asd";
                }

                $feladagCount = $currentMegrendelesek->where('feladag', 1)->count();
                $normalAdagCount = $currentMegrendelesek->where('feladag', 0)->count();

                if($feladagCount > intval($adagok['fel'])){
                    $currentMegrendelesek->where('feladag', 1)->take($feladagCount-intval($adagok['fel']))->each(function($feladag) {
                        $feladag->delete();
                    });
                }

                if($normalAdagCount > intval($adagok['normal'])){
                    $currentMegrendelesek->where('feladag', 0)->take($normalAdagCount-intval($adagok['normal']))->each(function($normal) {
                        $normal->delete();
                    });
                }

                
                if($feladagCount < intval($adagok['fel'])){
                    
                    $tetel = $tetelNev->tetelek
                        ->where('week_of_year', $this->getCurrentHet())
                        ->where('day_of_week',$nap+1)
                        ->where('year', Carbon::now()->year)
                        ->first();

                    while($feladagCount < intval($adagok['fel'])) {
                        \App\Megrendeles::create([
                            'megrendelo_id' => $data['megrendelo-id'],
                            'tetel_id' => $tetel->id,
                            'fizetesi_mod' => 'Tartozás',
                            'feladag' => 1,
                        ]);

                        $feladagCount++;
                    }
                }

                if($normalAdagCount < intval($adagok['normal'])) {
                    
                    while($normalAdagCount < intval($adagok['normal'])) {
                        $tetel = $tetelNev->tetelek
                            ->where('week_of_year', $this->getCurrentHet())
                            ->where('day_of_week',$nap+1)
                            ->where('year', Carbon::now()->year)
                            ->first();
                        \App\Megrendeles::create([
                            'megrendelo_id' => $data['megrendelo-id'],
                            'tetel_id' => $tetel->id,
                            'fizetesi_mod' => 'Tartozás',
                            'feladag' => 0,
                        ]);

                        $normalAdagCount++;
                    }
                }


                //Iff existing > proposed 
                    //Check If user has sufficient privileges
                //if proposed > existing
                    //Create the new records
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Megrendelések változtatása sikeres!'
        ]);
    }

    private function getCurrentHet() {
        return Carbon::now()->weekOfYear;
    }

    private function megrendelesTorles($isFeladag, $adagok, $key, &$currentMegrendelesek)
    {   
        $adagCount = $currentMegrendelesek->where('feladag', $isFeladag)->count();

        if($adagCount > intval($adagok[$key])){
            if(Auth::user()->munkakor != 'Kiszállító'){
                $currentMegrendelesek->where('feladag', $isFeladag)
                    ->take($adagCount - intval($adagok[$key]))
                    ->each(function($adag) {
                        $adag->delete();
                    });
            }
            else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Megrendelések törlése nem lehetséges. Kérem forduljon feletteséhez ha megrendelést szeretne törölni'
                ]);
            }
        }

    }
}
