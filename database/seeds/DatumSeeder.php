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
        $date = Carbon::now()->startOfYear();
        while($date->lte(Carbon::today()->endOfWeek())){
            App\Datum::create([
                'datum' => $date->format('Y-m-d'),
                'het' => $date->weekOfYear,
            ]);
            $date = $date->addDays(1);
        }
    }
}
