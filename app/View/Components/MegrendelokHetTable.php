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
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($megrendeloHetek, $het, $tartozas)
    {
        $this->megrendeloHetek = $megrendeloHetek;
        $this->fizetesiModok = \App\FizetesiMod::where('nev', '!=', 'Tartozás')->get();
        $this->tetelek = \App\TetelNev::all();
        $this->het = $het;
        $this->tartozas = $tartozas;
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
