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

        $megrendelok->each(function($megrendelo){
            $megrendelo['heti_osszeg'] = $megrendelo->megrendelesek->sum('tetel.ar');
        });
        //Todo: előző heti tartozás

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

        foreach($data['megrendelesek'] as $nap => $tetelek) {

            foreach($tetelek as $tetel => $adagok) {

                $tetelNev = \App\TetelNev::where('nev', $tetel)->first();

                $currentMegrendelesek = $megrendelo->megrendelesek
                    ->where('tetel.tetel_nev', $tetelNev->nev)
                    ->where('day_of_week', $nap+1);

                if(!$this->megrendelesTorles(true, $adagok, "fel", $currentMegrendelesek) || !$this->megrendelesTorles(false, $adagok, "normal", $currentMegrendelesek)){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Megrendelések utólagos törlése nem lehetséges'
                    ], 403);
                }


                $this->megrendelesHozzaadas(true, $adagok, 'fel', $currentMegrendelesek, $tetelNev, $nap, $data['megrendelo-id']);
                
                $this->megrendelesHozzaadas(false, $adagok, 'normal', $currentMegrendelesek, $tetelNev, $nap, $data['megrendelo-id']);

            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Megrendelések változtatása sikeres!'
        ]);
    }

    public function changeFizetesiStatusz()
    {
        
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
                return 0;
            }
        }

        return 1;

    }

    private function megrendelesHozzaadas($isFeladag, $adagok, $key, &$currentMegrendelesek, $tetelNev, $nap, $megrendeloId)
    {   
        $adagCount = $currentMegrendelesek->where('feladag', $isFeladag)->count();
        
        if($adagCount < intval($adagok[$key])){
                    
            $tetel = $tetelNev->tetelek
                ->where('week_of_year', $this->getCurrentHet())
                ->where('day_of_week',$nap+1)
                ->where('year', Carbon::now()->year)
                ->first();
            
            $latestTartozas = \App\Megrendeles::where('megrendelo_id', $megrendeloId)->where('fizetesi_mod', 'Tartozás')->latest()->first();
            
            if($latestTartozas === null){
                $latestMegrendeles = \App\Megrendeles::where('megrendelo_id', $megrendeloId)->latest()->first();
                $fizetesGroup = $latestMegrendeles === null ? 1 : $latestMegrendeles->fizetes_group+1; 
            }
            else {
                $fizetesGroup = $latestTartozas->fizetes_group;
            }

            while($adagCount < intval($adagok[$key])) {
                \App\Megrendeles::create([
                    'megrendelo_id' => $megrendeloId,
                    'tetel_id' => $tetel->id,
                    'fizetesi_mod' => 'Tartozás',
                    'feladag' => $isFeladag,
                    'fizetes_group' => $fizetesGroup,
                ]);

                $adagCount++;
            }
        }
    }
}
