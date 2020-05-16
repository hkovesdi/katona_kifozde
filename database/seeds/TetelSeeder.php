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
                'ar' => 2500
            ],
            [
                'nev' => 'B',
                'ar' => 2700
            ],
            [
                'nev' => 'L',
                'ar' => 1000
            ],
            [
                'nev' => 'F',
                'ar' => 3000
            ],
        ];
        
        \App\Tetel::insert($tetelek);
    }
}
