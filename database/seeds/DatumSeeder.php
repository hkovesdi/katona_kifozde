<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatumSeeder extends Seeder
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
            App\Datum::create(['datum' => $date->format('Y-m-d')]);
            $date = $date->addDays(1);
        }
    }
}
