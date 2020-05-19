<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class MegrendelesController extends Controller
{
    public function show()
    {
        $megrendelok = \App\Megrendelo::where('kiszallito_id',Auth::user()->id)
            ->with(['megrendeloHetek' => function($query){
                $query->where('het_id', $this->getCurrentHet())->with('megrendeloHetTetelek.tetel');
            }])
            ->get()
            ->toArray();
        
        $data = [
            'megrendelok' => $megrendelok,
            'het' => $this->getCurrentHet(),
            'tetelek' => \App\Tetel::all(),
        ];
        
        return view('welcome', $data);
    }

    private function getCurrentHet() {
        return Carbon::now()->weekOfYear;
    }
}
