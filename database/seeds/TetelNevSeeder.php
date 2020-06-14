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
                'nev' => 'L',
            ],
            [
                'nev' => 'T',
            ],
            [
                'nev' => 'Db',
            ],
            [
                'nev' => 'Dz',
            ],
            [
                'nev' => 'A1',
            ],
            [
                'nev' => 'A2',
            ],
            [
                'nev' => 'A3',
            ],
            [
                'nev' => 'A4',
            ],
            [
                'nev' => 'A5',
            ],
            [
                'nev' => 'S1',
            ],
            [
                'nev' => 'S2',
            ],
            [
                'nev' => 'S3',
            ],
            [
                'nev' => 'S4',
            ],
        ];
        
        foreach($tetelek as $tetel) {
            \App\TetelNev::create($tetel);
        }
    }
}
