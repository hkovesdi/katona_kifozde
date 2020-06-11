<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;

class MegrendelesController extends Controller
{
    public function show(Request $request, \App\User $user, String $evHet = null)
    {
        if($evHet === null) {
            $ev = Carbon::now()->year;
            $het = Carbon::now()->weekOfYear;
        }
        else {
            $temp = explode("-", $evHet);
            $ev = intval($temp[0]);
            $het = intval($temp[1]);
        }

        if(Auth::user()->munkakor == 'Kiszállító'  && ($ev != Carbon::now()->year || ($het != Carbon::now()->weekOfYear && $het != Carbon::now()->weekOfYear+1) || !Auth::user()->is($user))){
            return redirect('/');
        }

        $searchedMegrendelok = $this->searchMegrendeloByName($request->query('name'));

        $emptyMegrendelesTablazat = Helper::constructEmptyMegrendelesTablazat();

        $tartozasok = collect();
        $megrendeloHetek = collect();

        \App\MegrendeloHet::with(['megrendelo', 'datum', 'megrendelesek.tetel.datum'])
            ->whereHas('megrendelo', function($query) use($user){
                $query->where('kiszallito_id', $user->id);
            })
            ->where(function($query) use($ev, $het){
                $query->whereHas('datum', function($query) use($ev, $het) {
                    $query->whereYear('datum', $ev)->where('het', $het);
                })->orWhere('fizetve_at', NULL);
            })
            ->get()
            ->each(function($megrendeloHet) use($emptyMegrendelesTablazat, $ev, $het, $tartozasok, $megrendeloHetek){
                $megrendelesTablazat = $emptyMegrendelesTablazat;
                $osszeg = 0;
                $megrendeloHet->megrendelesek->each(function($megrendeles) use(&$megrendelesTablazat, &$osszeg){
                    $adag = $megrendeles->feladag ? 'fel' : 'egesz';
                    $tetel = $megrendeles->tetel;
                    $tetelAr = $megrendeles->feladag ? $tetel->ar*0.6 : $tetel->ar;
                    $megrendelesTablazat[$tetel->datum->dayOfWeek][$tetel->tetel_nev][$adag]++;
                    $megrendelesTablazat[$tetel->datum->dayOfWeek][$tetel->tetel_nev]['ar'] += $tetelAr;
                    $osszeg+=$tetelAr;
                });
                $megrendeloHet->setAttribute('megrendeles_tablazat', $megrendelesTablazat);
                $megrendeloHet->setAttribute('osszeg', $osszeg);
                
                if(($megrendeloHet->datum->het < $het || Carbon::parse($megrendeloHet->datum->datum)->year != $ev) && $het <= Carbon::now()->weekOfYear){
                    $tartozasok->push($megrendeloHet);
                }
                else if($het == $megrendeloHet->datum->het){
                    $megrendeloHetek->push($megrendeloHet);
                }
            });

        $data = [
            'kiszallitok' => Auth::user()->munkakor == 'Kiszállító' ?  collect() : \App\User::all(),
            'user' => $user,
            'megrendeloHetek' => $megrendeloHetek,
            'tartozasok' => $tartozasok,
            'searchedMegrendelok' => $searchedMegrendelok,
            'het' => $het,
            'ev' => $ev,
            'currentHet' => Carbon::now()->weekOfYear,
        ];

        return view('megrendelesek', $data);
    }

    /**
     * Handles the search for megrendelok
     * @param name The name of the megrendelo
     * Returns null if the $name param is null otherwise returns the search results
     */
    private function searchMegrendeloByName($name)
    {
        return $name == null ? null : \App\Megrendelo::with('kiszallito')->where('nev', 'LIKE', "%$name%")->get();
    }

    /**
     * 
     */
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

        if($megrendeloHet->fizetve_at != null) {
            return redirect()->back()->with('failure', ['A már kifizetett hét megrendeléseinek módosítása nem lehetséges']);
        }

        foreach($data['megrendelesek'] as $nap => $tetelek) {

            foreach($tetelek as $tetel => $adagok) {

                $tetelNev = \App\TetelNev::where('nev', $tetel)->first();

                $currentMegrendelesek = $megrendeloHet->megrendelesek
                    ->where('tetel.tetel_nev', $tetelNev->nev)
                    ->where('day_of_week', $nap+1);

                if(!$this->megrendelesTorles(true, $adagok, "fel", $currentMegrendelesek) || !$this->megrendelesTorles(false, $adagok, "normal", $currentMegrendelesek)){
                    return redirect()->back()->with('failure', ['Megrendelések utólagos törlése nem lehetséges']);
                }


                $this->megrendelesHozzaadas(true, $adagok, 'fel', $currentMegrendelesek, $tetelNev, $nap, $megrendeloHet);

                $this->megrendelesHozzaadas(false, $adagok, 'normal', $currentMegrendelesek, $tetelNev, $nap, $megrendeloHet);

            }
        }

        $megrendeloHet->update([
            'megjegyzes' => $data['megjegyzes']
        ]);

        return redirect()->back()->with('success', ['Megrendelések változtatása sikeres']);
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

                $megrendeloHet->update([
                    'fizetesi_mod' => 'Tartozás',
                    'fizetve_at' => NULL,
                ]);
        }
        else {
            $fizetesiMod = \App\FizetesiMod::where('nev', $data['fizetesi-mod'])->first()->nev;
            $megrendeloHet->update([
                'fizetesi_mod' => $fizetesiMod,
                'fizetve_at' => Carbon::now(),
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Fizetési státusz sikeresen módosítva!'
        ]);
        /*return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Sikerélmény elérve'
        ]);*/
    }

    public function megrendeloHetLetrehozas(Request $request) 
    {
        $data = $request->only('ev','het','megrendelo-id');

        $this->createMegrendeloHet($data['megrendelo-id'], $data['ev'], $data['het']);

        return redirect()->back()->with('success', ['Személy sikeresen hozzáadva a héthez']);
    }

    public function megrendeloLetrehozas(Request $request) 
    {
        $data = $request->only('nev', 'cim', 'tel', 'ev', 'het');

        if(Auth::user()->munkakor == 'Kiszállító'){
            $kiszallito_id = Auth::user()->id;
        }
        else {
            $kiszallito_id = \App\User::find($request->input('kiszallito-id'))->id;
        }

        $megrendelo = \App\Megrendelo::create([
            'kiszallito_id' => $kiszallito_id,
            'nev' => $data['nev'],
            'szallitasi_cim' => $data['cim'],
            'telefonszam' => $data['tel']
        ]);

        if(boolval($request->input('hozzaadas')))
            $this->createMegrendeloHet($megrendelo->id, $data['ev'], $data['het']);

        return redirect()->back()->with('success', ['Új megrendelő sikeresen létrehozva '.(boolval($request->input('hozzaadas')) ? 'és hozzáadva a héthez!' : '!')]);
    }

    private function createMegrendeloHet($megrendelo_id, $ev, $het)
    {
        $hetStartDatum = \App\Datum::whereYear('datum', $ev)->where('het', $het)->orderBy('datum', 'asc')->first();

        $megrendelo = \App\Megrendelo::when(Auth::user()->munkakor == "Kiszállító", function($query){
            $query->where('kiszallito_id', Auth::user()->id);  
        })
        ->find($megrendelo_id);

        $shitlord = \App\MegrendeloHet::where('megrendelo_id', $megrendelo_id)->where('het_start_datum_id', $hetStartDatum->id)->first();

        if(\App\MegrendeloHet::where('megrendelo_id', $megrendelo_id)->where('het_start_datum_id', $hetStartDatum->id)->first() === null && $megrendelo !== null){
            \App\MegrendeloHet::create([
                'megrendelo_id' => $megrendelo->id,
                'het_start_datum_id' => $hetStartDatum->id,
                'fizetesi_mod' => 'Tartozás',
                'fizetve_at' => NULL
            ]);
        }
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
