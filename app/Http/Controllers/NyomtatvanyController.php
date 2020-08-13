<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Helper;

class NyomtatvanyController extends Controller
{
    //

    public function show() {
        return view('nyomtatvanyok');
    }


    /**
     * Szakácsoknak a napi összesítőt jeleníti meg (dátum, tételek neve + hány darab)
     * @param string $datum - A dátum aminek a napi összesítője meg fog jelenni
     */
    public function showSzakacsView($datum) 
    {
        $tetelNevek = \App\TetelNev::all();
        $parsedDatum = \Carbon\Carbon::parse($datum);
        $megjegyzesek = \App\MegrendeloHet::whereHas('datum', function($query) use ($datum) {
            $query->where('datum', \Carbon\Carbon::parse($datum)->startOfWeek());
        })->pluck('megjegyzes');


        foreach($tetelNevek as $tetelNev) {
            $megrendelesek = $tetelNev->tetelek()->with('megrendelesek')->whereHas('datum', function($query) use($parsedDatum){
                $query->where('datum', $parsedDatum);
            })->first()
            ->megrendelesek;

            $tetelNev['darab'] = $megrendelesek->where('feladag', 0)->count()+$megrendelesek->where('feladag', 1)->count()/2;
        }

        $leves=$tetelNevek->where('nev', 'L')->first();

        $adb=$tetelNevek->where('nev', 'A')->first()->darab;

        $bdb=$tetelNevek->where('nev', 'B')->first()->darab;

        $tdb=$tetelNevek->where('nev', 'T')->first()->darab;

        $fdb=$tetelNevek->where('nev', 'F')->first()->darab;

        $leves->darab+=$adb+$bdb+$tdb+$fdb;

        $aMasodik=$tetelNevek->where('nev', 'A m')->first();

        $aMasodik->darab+=$adb;

        $bMasodik=$tetelNevek->where('nev', 'B m')->first();

        $bMasodik->darab+=$bdb;

        $fMasodik=$tetelNevek->where('nev', 'F m')->first();

        $fMasodik->darab+=$fdb;

        $tetelNevekFiltered = $tetelNevek->reject(function ($value, $key) {
            return $value->nev == 'A' || $value->nev == 'B' || $value->nev == 'Dz' || $value->nev == 'F';
        });




        $datum = array("datum" => $datum, "het" => $parsedDatum->weekOfYear, "nap" => $parsedDatum->dayOfWeek);

        return view("nyomtatvanyok.szakacs", [
            "megjegyzesek" => $megjegyzesek,
            "tetelek" => $tetelNevekFiltered,
            "datum" => $datum
        ]);
    }

    public function showFutarHeti(\App\User $kiszallito, String $evHet)
    {   
        $parsedEvHet = Helper::parseEvHet($evHet);
        $ev = intval($parsedEvHet[0]);
        $het = intval($parsedEvHet[1]);

        $fizetesiModok = \App\FizetesiMod::all()->each(function($fizetesiMod) {
            $fizetesiMod->setAttribute('osszeg', 0);
        });

        $megrendeloHetek = \App\MegrendeloHet::with(['megrendelesek.tetel.datum'])
        ->where('kiszallito_id', $kiszallito->id)
        ->whereHas('datum', function($query) use($ev, $het) {
            $query->whereYear('datum', $ev)->where('het', $het);
        })
        ->orderBy('sorrend')
        ->get()
        ->each(function($megrendeloHet)  use(&$fizetesiModok){
            $osszeg = $megrendeloHet->megrendelesek->sum(function($megrendeles) {
                return boolval($megrendeles->feladag) ? $megrendeles->tetel->ar * 0.6 : $megrendeles->tetel->ar;
            });

            $fizetesiMod = $fizetesiModok->where('nev', $megrendeloHet->fizetesi_mod)->first();
            $osszeg -=  $osszeg * ($megrendeloHet->kedvezmeny / 100);
            $fizetesiMod->osszeg+=$osszeg;

            $megrendeloHet->setAttribute('osszeg', $osszeg);
        });
        
        

        return view("nyomtatvanyok.futarHeti", [
            'megrendeloHetek' => $megrendeloHetek,
            'ev' => $ev,
            'het' => $het,
            'kiszallito' => $kiszallito,
            'fizetesiModok' => $fizetesiModok,
        ]);
        
        $pdf =  PDF::loadView("nyomtatvanyok.futarHeti", [
            'megrendeloHetek' => $megrendeloHetek,
            'ev' => $ev,
            'het' => $het,
            'kiszallito' => $kiszallito,
            'fizetesiModok' => $fizetesiModok,
        ])->setPaper('a4');

        return $pdf->stream('futar-heti-'.$kiszallito->username.'-'.$ev.'-'.$het.'.pdf');
    }

    public function showOsszesito(String $kezdete, String $vege) 
    {
        $kezdete = \Carbon\Carbon::parse($kezdete);
        $vege = \Carbon\Carbon::parse($vege);

        $osszeg = 0;

        $fizetesiModok = \App\FizetesiMod::all()->each(function($fizetesiMod) {
            $fizetesiMod->setAttribute('osszeg', 0);
        });

        $megrendelesek = \App\Megrendeles::with(['tetel.datum', 'megrendeloHet'])
        ->whereHas('tetel.datum', function($query) use ($kezdete,$vege){
            $query->whereBetween('datum', [$kezdete->format('Y-m-d'), $vege->format('Y-m-d')]);
        })
        ->get()
        ->each(function($megrendeles) use(&$osszeg, &$fizetesiModok) {
            $rendelesOsszeg = boolval($megrendeles->feladag) ? $megrendeles->tetel->ar * 0.6 : $megrendeles->tetel->ar;
            $rendelesOsszeg -= $megrendeles->megrendeloHet->kedvezmeny/100 * $rendelesOsszeg;
            
            $osszeg+= $rendelesOsszeg;
            
            $fizetesiMod = $fizetesiModok->where('nev', $megrendeles->megrendeloHet->fizetesi_mod)->first();
            $fizetesiMod->osszeg+=$rendelesOsszeg;           
        })
        ->groupBy('tetel.tetel_nev');

        $pdf =  PDF::loadView("nyomtatvanyok.osszesito", [
            'megrendelesek' => $megrendelesek,
            'kezdete' => $kezdete->format('Y-m-d'),
            'vege' => $vege->format('Y-m-d'),
            'fizetesiModok' => $fizetesiModok,
            'osszeg' => $osszeg,
        ])->setPaper('a4');

        return $pdf->stream('osszesito-'.$kezdete->format('Y-m-d').'-'.$vege->format('Y-m-d').'.pdf');
    }

    


}
