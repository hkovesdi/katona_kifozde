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

        foreach($tetelNevek as $tetelNev) {
            $tetelNev['darab'] = $tetelNev->tetelek()->whereHas('datum', function($query) use($parsedDatum){
                $query->where('datum', $parsedDatum);
            })->first()
            ->megrendelesek()
            ->count();
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

        //PDF::setOptions(['debugCss' => true]);
        $pdf =  PDF::loadView("nyomtatvanyok.szakacs", [
            "tetelek" => $tetelNevekFiltered,
            "datum" => $datum
        ])->setPaper('a4');

        return $pdf->stream('szakacs-osszesito-'.$parsedDatum.'.pdf');
      //  return view("nyomtatvanyok.szakacs", [
          //  "tetelek" => $tetelNevekFiltered,
          //  "datum" => $datum
        //]);
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
        ->get()
        ->each(function($megrendeloHet)  use(&$fizetesiModok){
            $osszeg = $megrendeloHet->megrendelesek->sum(function($megrendeles) {
                return boolval($megrendeles->feladag) ? $megrendeles->tetel->ar * 0.6 : $megrendeles->tetel->ar;
            });

            $fizetesiMod = $fizetesiModok->where('nev', $megrendeloHet->fizetesi_mod)->first();
            $fizetesiMod->osszeg+=$osszeg;

            $megrendeloHet->setAttribute('osszeg', $osszeg);
        });
        
        

/*         return view("nyomtatvanyok.futarHeti", [
            'megrendeloHetek' => $megrendeloHetek,
            'ev' => $ev,
            'het' => $het,
            'kiszallito' => $kiszallito
        ]); */
        
        $pdf =  PDF::loadView("nyomtatvanyok.futarHeti", [
            'megrendeloHetek' => $megrendeloHetek,
            'ev' => $ev,
            'het' => $het,
            'kiszallito' => $kiszallito,
            'fizetesiModok' => $fizetesiModok,
        ])->setPaper('a4');

        return $pdf->stream('futar-heti-.pdf');
    }

    


}
