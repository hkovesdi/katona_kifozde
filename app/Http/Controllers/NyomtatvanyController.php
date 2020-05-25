<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            $tetelNev['darab'] = $tetelNev->tetelek()->whereHas('datum', function($query) {
                $query->where('datum', $parsedDatum));
            })->first()
            ->megrendelesek()
            ->count();
        }

        $datum = array("datum" => $datum, "het" => $parsedDatum->weekOfYear, "nap" => $parsedDatum->dayOfWeek);

        //return view("nyomtatvanyok.szakacs", [
          //  "tetelek" => $tetelNevek,
         //   "datum" => $datum
        //]);

    }

    


}
