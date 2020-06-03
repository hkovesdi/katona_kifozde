<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MegrendelesController extends Controller
{
    public function show(String $evHet = null)
    {
        if($evHet === null) {
            $ev = Carbon::now()->year;
            $het = Carbon::now()->weekOfYear;
        }
        else {
            $temp = explode("-", $evHet);
            $ev = $temp[0];
            $het = $temp[1];
        }

        $megrendeloHetek = \App\MegrendeloHet::with(['megrendelo', 'megrendelesek.tetel.datum'])
            ->whereHas('datum', function($query) use($ev, $het) {
                $query->whereYear('datum', $ev)->where('het', $het);
            })
            ->when(Auth::user()->munkakor == "Kiszállító", function($query){
                return $query->whereHas('megrendelo', function($query){
                    $query->where('kiszallito_id', Auth::user()->id);
                });
            })
            ->get()
            ->each(function($megrendeloHet){
                $megrendeloHet['tartozas'] = \App\MegrendeloHet::where('megrendelo_id', $megrendeloHet->megrendelo_id)
                ->where('fizetesi_group', $megrendeloHet->fizetesi_group)
                ->whereHas('datum', function($query) use($megrendeloHet) {
                    $query->where('datum', '<', $megrendeloHet->datum->datum);
                })
                ->get()
                ->sum('osszeg');
            });

        $data = [
            'megrendeloHetek' => $megrendeloHetek,
            'het' => $het,
            'ev' => $ev,
            'tetelek' => \App\TetelNev::all(),
            'fizetesiModok' => \App\FizetesiMod::where('nev', '!=', 'Tartozás')->get(),
        ];

        return view('megrendelesek', $data);
    }

    public function modositas(Request $request)
    {
        $data = $request->all();

        $megrendeloHet = \App\MegrendeloHet::when(Auth::user()->munkakor == "Kiszállító", function($query){
            return $query->whereHas('megrendelo', function($query){
                $query->where('kiszallito_id', Auth::user()->id);
            });
        })
        ->where('id', $data['megrendelo-het-id'])
        ->first();

        foreach($data['megrendelesek'] as $nap => $tetelek) {

            foreach($tetelek as $tetel => $adagok) {

                $tetelNev = \App\TetelNev::where('nev', $tetel)->first();

                $currentMegrendelesek = $megrendeloHet->megrendelesek
                    ->where('tetel.tetel_nev', $tetelNev->nev)
                    ->where('day_of_week', $nap+1);

                if(!$this->megrendelesTorles(true, $adagok, "fel", $currentMegrendelesek) || !$this->megrendelesTorles(false, $adagok, "normal", $currentMegrendelesek)){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Megrendelések utólagos törlése nem lehetséges'
                    ], 403);
                }


                $this->megrendelesHozzaadas(true, $adagok, 'fel', $currentMegrendelesek, $tetelNev, $nap, $megrendeloHet);
                
                $this->megrendelesHozzaadas(false, $adagok, 'normal', $currentMegrendelesek, $tetelNev, $nap, $megrendeloHet);

            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Megrendelések változtatása sikeres!'
        ]);
    }

    public function changeFizetesiStatusz(Request $request, \App\MegrendeloHet $megrendeloHet)
    {   
        $data = $request->only('megrendelo-het-id', 'torles', 'fizetesi-mod');
        if(Auth::user()->munkakor == 'Kiszállító' && !Auth::user()->megrendelok->contains($megrendeloHet->megrendelo)){
            return response()->json([
                'status' => 'failure',
                'message' => 'Csak az önhöz tartozó megrendelők fizetési státuszának változtatása lehetséges'
            ], 403);
        }

        if($data['torles']){
            if(Auth::user()->munkakor == 'Kiszállító'){
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Fizetési státusz törlése a kiszállítóknak nem lehetséges'
                ], 403);
            }

            \App\MegrendeloHet::where('megrendelo_id', $megrendeloHet->megrendelo_id)
                ->where('fizetesi_group', $megrendeloHet->fizetesi_group)
                ->get()
                ->each(function($megrendeloHet) {
                    $megrendeloHet->update([
                        'fizetesi_mod' => 'Tartozás',
                        'fizetve_at' => NULL,
                    ]);
                });
        }
        else {
            $fizetesiMod = \App\FizetesiMod::where('nev', $data['fizetesi-mod'])->first()->nev;
            \App\MegrendeloHet::where('megrendelo_id', $megrendeloHet->megrendelo_id)
                ->where('fizetesi_group', $megrendeloHet->fizetesi_group)
                ->get()
                ->each(function($megrendeloHet) {
                    $megrendeloHet->update([
                        'fizetesi_mod' => $fizetesiMod,
                        'fizetve_at' => Carbon::now(),
                    ]);
                });
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Fizetési státusz sikeresen módosítva!'
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
                return 0;
            }
        }

        return 1;

    }

    private function megrendelesHozzaadas($isFeladag, $adagok, $key, &$currentMegrendelesek, $tetelNev, $nap, $megrendeloHet)
    {   
        $adagCount = $currentMegrendelesek->where('feladag', $isFeladag)->count();
        
        if($adagCount < intval($adagok[$key])){
                    
            $tetel = $tetelNev->tetelek
                ->where('week_of_year', $megrendeloHet->datum->het)
                ->where('day_of_week',$nap+1)
                ->where('year', $megrendeloHet->datum->year)
                ->first();
            

            while($adagCount < intval($adagok[$key])) {
                \App\Megrendeles::create([
                    'megrendelo_het_id' => $megrendeloHet->id,
                    'tetel_id' => $tetel->id,
                    'feladag' => $isFeladag,
                ]);

                $adagCount++;
            }
        }
    }
}
