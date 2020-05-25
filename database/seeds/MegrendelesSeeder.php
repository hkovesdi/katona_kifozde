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
        foreach(\App\Megrendelo::all() as $megrendelo) {
            foreach(\App\Datum::all() as $datum) {
                if((bool)random_int(0,1) && Carbon::parse($datum->datum)->isWeekDay()) {
                    App\Megrendeles::create([
                        'megrendelo_id' => $megrendelo->id,
                        'tetel_id' => App\Tetel::where('datum_id', $datum->id)->inRandomOrder()->first()->id,
                        'fizetesi_mod' => 'Tartozás',
                        'fizetes_group' => 1,
                    ]);
                }
            }
        }
    }
}
