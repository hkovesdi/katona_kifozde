<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Log;

class MegrendelesController extends Controller
{
    public function show(Request $request, \App\User $user, String $evHet = null)
    {
        $parsedEvHet = Helper::parseEvHet($evHet);
        $ev = intval($parsedEvHet[0]);
        $het = intval($parsedEvHet[1]);

        if(Auth::user()->munkakor == 'Kiszállító'  && ($ev != Carbon::now()->year || ($het != Carbon::now()->weekOfYear && $het != Carbon::now()->weekOfYear+1) || !Auth::user()->is($user))){
            return redirect('/');
        }

        $searchedMegrendelok = $this->searchMegrendeloByName($request->query('name'))->each(function($megrendelo) use($ev,$het){
            $hetiFutar = $megrendelo->megrendeloHetek()->whereHas('datum', function($query) use($ev,$het){
                $query->whereYear('datum', $ev)->where('het', $het);
            })->first()['kiszallito'];

            $megrendelo->setAttribute('kiszallito', $hetiFutar);
        });

        $emptyMegrendelesTablazat = Helper::constructEmptyMegrendelesTablazat();

        $tartozasok = collect();
        $megrendeloHetek = collect();

        \App\MegrendeloHet::with(['megrendelo', 'datum', 'megrendelesek.tetel.datum'])
            ->where('kiszallito_id', $user->id)
            ->where(function($query) use($ev, $het){
                $query->whereHas('datum', function($query) use($ev, $het) {
                    $query->whereYear('datum', $ev)->where('het', $het);
                })->orWhere('fizetve_at', NULL);
            })
            ->orderBy('sorrend', 'asc')
            ->get()
            ->each(function($megrendeloHet) use($emptyMegrendelesTablazat, $ev, $het, $tartozasok, $megrendeloHetek){
                $osszeg = 0;
                $osszegOsszesito = "";
                $megrendeloHet->megrendelesek->groupBy('tetel.tetel_nev')
                ->each(function($megrendelesek,$tetelNev) use(&$osszegOsszesito, &$osszeg){
                    $adatok = array_fill_keys(array('fel','normal','felAr','normalAr'),0);
                    $megrendelesek->each(function($megrendeles) use(&$adatok, &$osszeg){
                        $ar = $megrendeles->tetel->ar;
                        if(boolval($megrendeles->feladag)) {
                            $adatok['fel']++;
                            $adatok['felAr']+=$ar * 0.6;
                        }
                        else {
                            $adatok['normal']++;
                            $adatok['normalAr'] += $ar;
                        }
                    });
                    $osszeg+=$adatok['felAr']+$adatok['normalAr'];
                    $osszegOsszesito .= ($adatok['fel'] > 0 ? $adatok['fel'].' <i>fél</i> ' : "").($adatok['normal'] > 0 ? $adatok['normal'].' <i>normál</i> ' : "").'<b>'.$tetelNev.'</b> = '.strval($adatok['felAr']+$adatok['normalAr']).' Ft <br> ';
                });

                if($megrendeloHet->kedvezmeny != 0){

                    $osszegOsszesito.='Össz: <i>'.$osszeg.' Ft </i> - <i>'.$megrendeloHet->kedvezmeny.'% kedvezmény </i> <br>';
                }
                $osszeg -=  $osszeg * ($megrendeloHet->kedvezmeny / 100);
                $osszegOsszesito.='<hr> Végösszeg: <b>'.$osszeg.' Ft </b>';

                $megrendeloHet->setAttribute('osszeg_osszesito',$osszegOsszesito);
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
            'tartozasok' => $tartozasok->sortBy(function($megrendeloHet) {
                return $megrendeloHet->datum->het;
            }),
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
        return \App\Megrendelo::where('nev', 'LIKE', "%$name%")->get();
    }


    public function megrendeloHetTorles(Request $request, \App\User $user)
    {   
        if(Auth::user()->munkakor == 'Kiszállító' && $user->id != Auth::user()->id){
            return redirect()->back()->with('failure', ['Más kiszállító alá tartozó megrendelők hetének törlése nem lehetséges!']);
        }
        
        $megrendeloHetekId = $request->input('megrendelo-het') ?? array();

        foreach($megrendeloHetekId as $megrendeloHetId) {
            $megrendeloHet = $user->megrendeloHetek()->find(intval($megrendeloHetId));

            if(!$megrendeloHet->megrendelesek->isEmpty()) {
                return redirect()->back()->with('failure', ['A megrendelőket csak akkor lehet törölni a hétről, ha nincsen hozzájuk tartozó rendelés.']);
            }

            $megrendeloHet->delete();
        }

        return redirect()->back()->with('success', ['Megrendelők sikeresen törölve a hétről!']);
    }

    public function sorrendModositas(Request $request, \App\User $user)
    {
        if(!$user->is(Auth::user()) && Auth::user()->munkakor == 'Kiszállító')
        {
            return response()->json([
                'status' => 'failure',
                'message' => 'Más kiszállító megrendelései sorrendjének megváltoztatása nem lehetséges'
            ], 403);
        }

        $data = $request->only('ids', 'ev', 'het');

        foreach($data['ids'] as $idx => $id) 
        {
            \App\MegrendeloHet::where('kiszallito_id', $user->id)
            ->whereHas('datum', function($query) use($data){
                $query->whereYear('datum', $data['ev'])->where('het', $data['het']);
            })->where('megrendelo_id', intval($id))->first()->update([
                'sorrend' => $idx+1
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Sorrend sikeresen módosítva'
        ]);
    }

    public function kedvezmenyValtoztatas(Request $request, \App\MegrendeloHet $megrendeloHet)
    {
        if(Auth::user()->munkakor == 'Kiszállító' && $megrendeloHet->kiszallito_id != Auth::user()->id){
            return redirect()->back()->with('failure', ['Más futárhoz tartozó megrendelők kedvezményének módosítására nincs lehetőség']);
        }

        $kedvezmeny = $request->input('kedvezmeny');

        if($kedvezmeny < 0 || $kedvezmeny > 100 || $kedvezmeny % 1 != 0 || $kedvezmeny === null) 
        {
            return redirect()->back()->with('failure', ['Kérem 0 és 100 közötti egész számot adjon meg a kedvezmény értékének!']);
        }

        $megrendeloHet->update([
            'kedvezmeny' => $kedvezmeny
        ]);

        return redirect()->back()->with('success', ['Kedvezmény sikeresen módosítva!']);
    }

    /**
     * 
     */
    public function modositas(Request $request)
    {
        $data = $request->all();

        $megrendeloHet = \App\MegrendeloHet::when(Auth::user()->munkakor == "Kiszállító", function($query){
            return $query->where('kiszallito_id', Auth::user()->id);
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
        if(Auth::user()->munkakor == 'Kiszállító' && !Auth::user()->megrendeloHetek->contains($megrendeloHet)){
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
    }

    public function megrendeloHetLetrehozas(Request $request, \App\User $user, \App\Megrendelo $megrendelo) 
    {
        $data = $request->only('ev','het');
        $hetStartDatum = \App\Datum::whereYear('datum', $data['ev'])->where('het', $data['het'])->first();
        $megrendeloHet = \App\MegrendeloHet::where('megrendelo_id', $megrendelo->id)->where('het_start_datum_id', $hetStartDatum->id)->first();

        if(Auth::user()->munkakor == 'Kiszállító' && !$user->is(Auth::user())){
            return redirect()->back()->with('failure', ['Más kiszállítókhoz nem lehet megrendelőt hozzáadni']);
        }

        if($megrendeloHet !== null && Auth::user()->munkakor == 'Kiszállító'){
            return redirect()->back()->with('failure', ['A megrendelőt nem lehet hozzáadni a héthez mert másik futárhoz tartozik']);
        }
        else if(Auth::user()->munkakor != 'Kiszállító' && $megrendeloHet !== null) {
            $megrendeloHet->update([
                'kiszallito_id' => $user->id
            ]);
        }
        else {
            $prevMegrendeloHet = \App\MegrendeloHet::where('het_start_datum_id', $hetStartDatum->id)
                ->where('kiszallito_id', $user->id)
                ->orderBy('sorrend', 'desc')
                ->first();

            \App\MegrendeloHet::create([
                'kiszallito_id' => $user->id,
                'megrendelo_id' => $megrendelo->id,
                'het_start_datum_id' => $hetStartDatum->id,
                'sorrend' => $prevMegrendeloHet === null ? 1 : $prevMegrendeloHet->sorrend+1,
                'fizetesi_mod' => 'Tartozás',
                'fizetve_at' => NULL
            ]);
        }

        return redirect()->back()->with('success', ['Személy sikeresen hozzáadva a héthez']);
    }

    public function showMegrendelesTable(\App\MegrendeloHet $megrendeloHet) 
    {
        if(Auth::user()->munkakor == 'Kiszállító' && $megrendeloHet->kiszallito_id != Auth::user()->id){
            return response()->json([
                'status' => 'failure',
                'message' => 'Másik kiszállítóhoz tartozó megrendelés táblázat elérése nem lehetséges'
            ]);
        }

        $megrendelesTablazat = Helper::constructEmptyMegrendelesTablazat();

        $megrendeloHet->megrendelesek->each(function($megrendeles) use(&$megrendelesTablazat){
            $adag = $megrendeles->feladag ? 'fel' : 'egesz';
            $tetel = $megrendeles->tetel;
            $tetelAr = $megrendeles->feladag ? $tetel->ar*0.6 : $tetel->ar;
            $megrendelesTablazat[$tetel->datum->dayOfWeek][$tetel->tetel_nev][$adag]++;
            $megrendelesTablazat[$tetel->datum->dayOfWeek][$tetel->tetel_nev]['ar'] += $tetelAr;
        });

        $megrendeloHet->setAttribute('megrendeles_tablazat', $megrendelesTablazat);

        return view('components.megrendelesek-table', [
            'megrendeloHet' => $megrendeloHet, 
            'tetelek' => \App\TetelNev::all(), 
            'tartozas' => 0
        ]);

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
