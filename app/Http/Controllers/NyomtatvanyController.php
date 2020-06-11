<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

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

        $leves->darab+=$adb+$bdb+$tdb;

        $aMasodik=$tetelNevek->where('nev', 'A m')->first();

        $aMasodik->darab+=$adb;

        $bMasodik=$tetelNevek->where('nev', 'B m')->first();

        $bMasodik->darab+=$bdb;

        $tetelNevekFiltered = $tetelNevek->reject(function ($value, $key) {
            return $value->nev == 'A' || $value->nev == 'B' || $value->nev == 'Dz';
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

    public function showFutarHeti()
    {
        
        $megrendelok = array([
                'id' => 1,
                'nev' => 'Kiss Jenő',
                'fizmod' => 'Készpénz',
                'osszeg' => 5000
            ],[
                'id' => 2,
                'nev' => 'Csuhai János',
                'fizmod' => 'Szépkártya',
                'osszeg' => 6700
            ],[
                'id' => 3,
                'nev' => 'Balogh Robin',
                'fizmod' => 'Baptista',
                'osszeg' => 9990,
            ],[
                'id' => 4,
                'nev' => 'Kathi Béla',
                'fizmod' => 'Szépkártya',
                'osszeg' => 6969,
            ],[
                'id' => 5,
                'nev' => 'Bohos Kornél',
                'fizmod' => 'Készpénz',
                'osszeg' => 2000,
            ],[
                'id' => 6,
                'nev' => 'Bitang Vagyok',
                'fizmod' => 'Szépkártya',
                'osszeg' => 3000
            ],[
                'id' => 7,
                'nev' => 'Elek Kelek',
                'fizmod' => 'Bankkártya',
                'osszeg' => 4000
            ],[
                'id' => 8,
                'nev' => 'Menő Jenő',
                'fizmod' => 'Baptista',
                'osszeg' => 2000,
            ],[
                'id' => 9,
                'nev' => 'Bekap Hatod',
                'fizmod' => 'Bankkártya',
                'osszeg' => 1500,
            ],[
                'id' => 10,
                'nev' => 'Görcs Ikrek',
                'fizmod' => 'Tartozás',
                'osszeg' => 6000,
            ], [
                'id' => 11,
                'nev' => 'Kiss Jenő',
                'fizmod' => 'Készpénz',
                'osszeg' => 5000
            ],[
                'id' => 12,
                'nev' => 'Csuhai János',
                'fizmod' => 'Szépkártya',
                'osszeg' => 6700
            ],[
                'id' => 13,
                'nev' => 'Balogh Robin',
                'fizmod' => 'Baptista',
                'osszeg' => 9990,
            ],[
                'id' => 14,
                'nev' => 'Kathi Béla',
                'fizmod' => 'Szépkártya',
                'osszeg' => 6969,
            ],[
                'id' => 15,
                'nev' => 'Bohos Kornél',
                'fizmod' => 'Készpénz',
                'osszeg' => 2000,
            ],[
                'id' => 16,
                'nev' => 'Bitang Vagyok',
                'fizmod' => 'Szépkártya',
                'osszeg' => 3000
            ],[
                'id' => 17,
                'nev' => 'Elek Kelek',
                'fizmod' => 'Bankkártya',
                'osszeg' => 4000
            ],[
                'id' => 18,
                'nev' => 'Menő Jenő',
                'fizmod' => 'Baptista',
                'osszeg' => 2000,
            ],[
                'id' => 19,
                'nev' => 'Bekap Hatod',
                'fizmod' => 'Bankkártya',
                'osszeg' => 1500,
            ],[
                'id' => 20,
                'nev' => 'Görcs Ikrek',
                'fizmod' => 'Tartozás',
                'osszeg' => 6000,
            ], [
                'id' => 21,
                'nev' => 'Kiss Jenő',
                'fizmod' => 'Készpénz',
                'osszeg' => 5000
            ],[
                'id' => 22,
                'nev' => 'Csuhai János',
                'fizmod' => 'Szépkártya',
                'osszeg' => 6700
            ],[
                'id' => 23,
                'nev' => 'Balogh Robin',
                'fizmod' => 'Baptista',
                'osszeg' => 9990,
            ],[
                'id' => 24,
                'nev' => 'Kathi Béla',
                'fizmod' => 'Szépkártya',
                'osszeg' => 6969,
            ],[
                'id' => 25,
                'nev' => 'Bohos Kornél',
                'fizmod' => 'Készpénz',
                'osszeg' => 2000,
            ],[
                'id' => 26,
                'nev' => 'Bitang Vagyok',
                'fizmod' => 'Szépkártya',
                'osszeg' => 3000
            ],[
                'id' => 27,
                'nev' => 'Elek Kelek',
                'fizmod' => 'Bankkártya',
                'osszeg' => 4000
            ],[
                'id' => 28,
                'nev' => 'Menő Jenő',
                'fizmod' => 'Baptista',
                'osszeg' => 2000,
            ],[
                'id' => 29,
                'nev' => 'Bekap Hatod',
                'fizmod' => 'Bankkártya',
                'osszeg' => 1500,
            ],[
                'id' => 30,
                'nev' => 'Görcs Ikrek',
                'fizmod' => 'Tartozás',
                'osszeg' => 6000,
            ]);

    
            return view("nyomtatvanyok.futarHeti", [
                "megrendelok" => $megrendelok,
            ]);
    }

    


}
