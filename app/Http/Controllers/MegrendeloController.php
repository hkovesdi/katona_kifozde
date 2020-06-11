<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MegrendeloController extends Controller
{
    public function show(){

        $data = [
            'megrendelok' => \App\Megrendelo::with('kiszallito')->get(),
            'kiszallitok' => \App\User::where('munkakor', 'Kiszállító')->get()
        ];

        return view('megrendelok', $data);
    }

    public function modositas(Request $request, \App\Megrendelo $megrendelo) {

    }
}
