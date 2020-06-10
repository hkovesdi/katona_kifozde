<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Helper;

class TetelController extends Controller
{
    public function show() 
    {
        $emptyTetelTablazat = Helper::constructEmptyTetelTablazat();
        
        \App\Tetel::whereHas('datum', function($query){
            $query->whereBetween('datum', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        })
        ->get()
        ->each(function($tetel) use (&$emptyTetelTablazat){
            $emptyTetelTablazat[$tetel->day_of_week][$tetel->tetel_nev]['ar'] = $tetel->ar;
            $emptyTetelTablazat[$tetel->day_of_week][$tetel->tetel_nev]['id'] = $tetel->id;
        });

        $data = [
            'tetelTablazat' => $emptyTetelTablazat,
            'tetelNevek' => \App\TetelNev::all()->pluck('nev'),
        ];

        return view('tetelek', $data);
    }

    public function tetelArModositas(Request $request) 
    {
        $data = $request->all();

        foreach($data['tetelek'] as $napIdx => $tetelek){
            foreach($tetelek as $tetelNev => $tetel) {
                $tetel = \App\Tetel::with('datum')->find($tetel['id']);

                if(boolval($request->input('jovohettol'))) {
                    $datum = \App\Datum::where('datum', \Carbon\Carbon::parse($tetel->datum->datum)->addDays(7))->first();
                    $tetel = \App\Tetel::where('tetel_nev', $tetel->nev)->where('datum_id', $datum->id)->first();
                }

                $tetel->update([
                    'ar' => intval($tetel['ar'])
                ]);
            }
        }

        return redirect()->back()->with('success', ['Tételek árának módosítása sikeres']);
    }
}
