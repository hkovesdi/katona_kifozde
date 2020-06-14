<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
class TetelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        foreach(\App\Datum::all() as $datum) {
            if(Carbon::parse($datum->datum)->isWeekDay()) {
                foreach(\App\TetelNev::all() as $tetelNev) {
                    \App\Tetel::create([
                        'tetel_nev' => $tetelNev->nev,
                        'datum_id' => $datum->id,
                        'ar' => random_int(1000,3000),
                    ]);
                }
            }
        }
    }
}
