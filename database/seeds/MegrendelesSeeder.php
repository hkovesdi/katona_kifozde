<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class MegrendelesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(\App\MegrendeloHet::all() as $megrendeloHet) {
            foreach(\App\Datum::where('het', $megrendeloHet->datum->het)->get() as $datum) {
                if(Carbon::parse($datum->datum)->isWeekDay()) {
                    if(Carbon::parse($megrendeloHet->fizetve_at)->lte(Carbon::parse($datum->datum))) {
                        $tetel = \App\Tetel::whereHas('datum', function($query) use($datum) {
                            $query->where('datum', $datum->datum);
                        })
                        ->inRandomOrder()
                        ->first();

                        \App\Megrendeles::create([
                            'megrendelo_het_id' => $megrendeloHet->id,
                            'tetel_id' => $tetel->id,
                            'feladag' => random_int(0,1)
                        ]);
                    }
                }
            }
        }
    }
}
