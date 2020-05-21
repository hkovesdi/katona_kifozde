<?php

use Illuminate\Database\Seeder;

class TetelNevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $tetelek = [
            [
                'nev' => 'A',
            ],
            [
                'nev' => 'B',
            ],
            [
                'nev' => 'A m',
            ],
            [
                'nev' => 'B m',
            ],
            [
                'nev' => 'L', //Pénteki leves 650 good luck
            ],
            [
                'nev' => 'T',
            ],
            [
                'nev' => 'Dz',
            ],
        ];
        
        \App\TetelNev::insert($tetelek);
    }
}
