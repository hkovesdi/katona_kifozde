<?php

use Illuminate\Database\Seeder;

class MegrendeloHetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        foreach(\App\Het::all() as $het) {
                
            foreach(\App\Megrendelo::all() as $megrendelo) {
                \App\MegrendeloHet::create([
                    'megrendelo_id' => $megrendelo->id,
                    'het_id' => $het->id,
                    'fizetett' => rand(0,1),
                    'szepkartya' => rand(0,1),
                ]);
            }

        }
    }
}
