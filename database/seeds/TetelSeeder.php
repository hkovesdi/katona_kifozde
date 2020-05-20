<?php

use Illuminate\Database\Seeder;

class TetelSeeder extends Seeder
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
                'ar' => 1290
            ],
            [
                'nev' => 'B',
                'ar' => 1290
            ],
            [
                'nev' => 'A m',
                'ar' => 950
            ],
            [
                'nev' => 'B m',
                'ar' => 950
            ],
            [
                'nev' => 'L', //Pénteki leves 650 good luck
                'ar' => 500
            ],
            [
                'nev' => 'T',
                'ar' => 950
            ],
            [
                'nev' => 'Dz',
                'ar' => 80
            ],
        ];
        
        \App\Tetel::insert($tetelek);
    }
}
