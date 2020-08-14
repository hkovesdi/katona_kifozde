<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MegrendelokHetTable extends Component
{   
    public $megrendeloHetek;
    
    public $fizetesiModok;

    public $tetelek;

    public $het;

    public $tartozas;

    public $user;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($megrendeloHetek, $het, $tartozas, $user)
    {
        $this->megrendeloHetek = $megrendeloHetek;
        $this->fizetesiModok = \App\FizetesiMod::where('nev', '!=', 'Tartozás')->where('active', 1)->get();
        $this->tetelek = \App\TetelNev::all();
        $this->het = $het;
        $this->tartozas = $tartozas;
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.megrendelok-het-table');
    }
}
