<?php

use Illuminate\Database\Seeder;

class FizetesiModokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'nev' => 'Készpénz'
            ],
            [
                'nev' => 'Bankkártya'
            ],
            [
                'nev' => 'Szépkártya'
            ],
            [
                'nev' => 'Baptista'
            ],
            [
                'nev' => 'Tartozás'
            ],
        ];

        \App\FizetesiMod::insert($data);
    }
}
