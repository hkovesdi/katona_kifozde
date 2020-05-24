<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NyomtatvanyController extends Controller
{
    //

    public function show() {
        return view('nyomtatvanyok');
    }
}
