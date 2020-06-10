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
        });

        return view('tetelek');
    }
}
