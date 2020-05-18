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
            ->with('megrendeloHetek.megrendeloHetTetelek.tetel')
            ->whereHas('megrendeloHetek.het', function($query) {
                $query->where('id', $this->getCurrentHet());
            })
            ->get()->toArray();

        return view('welcome')->compact($megrendelok);
    }

    private function getCurrentHet() {
        return Carbon::now()->weekOfYear;
    }
}
