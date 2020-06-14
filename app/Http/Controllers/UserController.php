<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function jelszoValtoztatas(Request $request) 
    {
        $data = $request->only('new','current','confirm');

        if(!Hash::check($data['current'], Auth::user()->password)){
            return redirect()->back()->with('failure', ['Hibás jelszó']);
        }

        if($data['new'] !== $data['confirm']){
            return redirect()->back()->with('failure', ['Az új jelszó nem egyezik']);
        }

        Auth::user()->update([
            'password' => Hash::make($data['new']),
        ]);

        Auth::logout();

        return redirect('login')->with('success', ['Sikeres jelszó változtatás, kérem jelentkezzen be újra!']);
    }
    
    public function create(Request $request)
    {
        $data = $request->all();

        if($data['password'] !== $data['confirm']) {
            return redirect()->back()->with('failure', ['A jelszavak nem egyeznek']);
        }

        $munkakor = \App\Munkakor::where('nev', $data['munkakor'])->first();

        \App\User::create([
            'nev' => $data['nev'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'munkakor' => $munkakor->nev          
        ]);

        return redirect()->back()->with('success', ['Felhasználó sikeresen létrehozva!']);

    }
}
