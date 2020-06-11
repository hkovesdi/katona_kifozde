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
}
