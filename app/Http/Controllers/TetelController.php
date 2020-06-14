<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Helper;

class TetelController extends Controller
{
    public function show(String $evHet = null)
    {   
        $parsedEvHet = Helper::parseEvHet($evHet);
        $ev = intval($parsedEvHet[0]);
        $het = intval($parsedEvHet[1]);

        $emptyTetelTablazat = Helper::constructEmptyTetelTablazat();
        
        $tetelek = \App\Tetel::whereHas('datum', function($query) use($ev,$het){
            $query->whereYear('datum', $ev)->where('het', $het);
        })
        ->get()
        ->each(function($tetel) use (&$emptyTetelTablazat){
            $emptyTetelTablazat[$tetel->day_of_week][$tetel->tetel_nev]['ar'] = $tetel->ar;
            $emptyTetelTablazat[$tetel->day_of_week][$tetel->tetel_nev]['id'] = $tetel->id;
        });

        $data = [
            'tetelTablazat' => $emptyTetelTablazat,
            'tetelNevek' => \App\TetelNev::all()->pluck('nev'),
            'ev' => $ev,
            'het' => $het,
            'letezik' => $tetelek->count() > 0,
        ];

        return view('tetelek', $data);
    }

    public function tetelArModositas(Request $request) 
    {
        $data = $request->all();

        if($data['ev'] < Carbon::now()->year || $data['het'] < Carbon::now()->weekOfYear) {
            return redirect()->back()->with('failure', ['Tétel(ek) árának módosítása visszamenőleg nem lehetséges']);
        }

        if($data['ev'] )
        foreach($data['tetelek'] as $napIdx => $tetelek){
            foreach($tetelek as $tetelNev => $tetel) {
                $tetelFromDB = \App\Tetel::with('datum')
                ->whereHas('datum', function($query) use($data){
                    $query->whereYear('datum', $data['ev'])->where('het', $data['het']);
                })
                ->find($tetel['id']); //maybe check the date in case of ID tampering?

                $tetelFromDB->update([
                    'ar' => intval($tetel['ar'])
                ]);
            }
        }

        return redirect()->back()->with('success', ['Tétel(ek) árának módosítása sikeres']);
    }
}
