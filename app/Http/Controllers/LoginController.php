<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{   

    public function show() {
        if(Auth::check()) {
            return redirect()->route('home');
        }
        return view('login');
    }
    
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('')->with('success', ['Sikeres bejelentkezés!']);
        }

        return redirect()->back()->with('failure', ['Hibás felhasználónév vagy jelszó!']);

    }

    public function logout()
    {
        if(Auth::check()){
            Auth::logout();
        }

        return redirect('login')->with('success', ['Kijelentkezve']);
    }
}
