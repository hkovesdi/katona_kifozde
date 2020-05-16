<?php

use Illuminate\Database\Seeder;

class MegrendeloHetTetelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $napok = ['Hétfő', 'Kedd', 'Szerda', 'Csütörtök', 'Péntek'];
        foreach(\App\MegrendeloHet::all() as $megrendeloHet) {
            foreach($napok as $nap) {
                if(rand(0,10) > 4) {
                    \App\MegrendeloHetTetel::create([
                        'megrendelo_het_id' => $megrendeloHet->id,
                        'tetel_id' => \App\Tetel::inRandomOrder()->first()->id,
                        'nap' => $nap,
                        'mennyiseg' => rand(1,2),
                    ]);
                }
            }
        }
    }
}
