<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MegrendeloController extends Controller
{
    public function show()
    {

        $data = [
            'megrendelok' => \App\Megrendelo::orderBy('nev', 'asc')->get(),
            'kiszallitok' => \App\User::where('munkakor', 'Kiszállító')->orWhere('munkakor', 'Szakács')->get()
        ];

        return view('megrendelok', $data);
    }

    public function showTartozasok() 
    {   

        $emptyMegrendelesTablazat = Helper::constructEmptyMegrendelesTablazat();

        $currentHet = \Carbon\Carbon::now()->weekOfYear;
        
        $tartozasok = \App\MegrendeloHet::with(['megrendelo', 'megrendeles.tetel.datum'])
        ->where(function($query)  use($ev, $het){
            $query->whereHas('datum', function($query) use($ev, $het) {
                $query->whereYear('datum', $ev)->where('het', '<', $het);
            })->orWhereHas('datum', function($query) use($ev, $het) {
                $query->whereYear('datum', '!=', $ev);
            });
        })
        ->where('fizetve_at', NULL)
        ->get();

        return view('tartozasok', $data);
    }

    public function modositas(Request $request, \App\Megrendelo $megrendelo) {
        $data = $request->only('nev','cim','tel');

        if($data['nev'] === null || $data['cim'] === null || $data['tel'] === null){
            return redirect()->back()->with('failure', ['Kérem minden mezőt töltsön ki']);
        }

        $megrendelo->update([
            'nev' => $data['nev'],
            'szallitasi_cim' => $data['cim'],
            'telefonszam' => $data['tel'],
        ]);

        return redirect()->back()->with('success', ['Megrendelő változtatása sikeres']);
    }

    public function letrehozas(Request $request)
    {
        $data = $request->only('nev', 'cim', 'tel');

        if(\App\Megrendelo::whereRaw('LOWER(nev) = ?', [strtolower($data['nev'])])->whereRaw('LOWER(szallitasi_cim) = ?', [strtolower($data['cim'])])->exists()){
            return redirect()->back()->with('failure', ['Már létezik ilyen megrendelő']);
        }

        if($data['nev'] === null || $data['cim'] === null || $data['tel'] === null){
            return redirect()->back()->with('failure', ['Kérem minden mezőt töltsön ki']);
        }
        

        $megrendelo = \App\Megrendelo::create([
            'nev' => $data['nev'],
            'szallitasi_cim' => $data['cim'],
            'telefonszam' => $data['tel']
        ]);

        return redirect()->back()->with('success', ['Új megrendelő sikeresen létrehozva']);
    }
}
