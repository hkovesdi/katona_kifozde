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
        $date = Carbon::today();
        while($date->lt(Carbon::today()->addYears(1))){
            foreach(\App\TetelNev::all() as $tetelNev) {
                \App\Tetel::create([
                    'tetel_nev' => $tetelNev->nev,
                    'datum_id' => \App\Datum::where('datum', $date->format('Y-m-d'))->first()->id,
                    'ar' => random_int(1000,3000),
                ]);
            }
            $date = $date->addDays(1);
        }
    }
}
