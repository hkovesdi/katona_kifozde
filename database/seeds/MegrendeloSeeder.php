<?php

use Illuminate\Database\Seeder;

class MegrendeloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Megrendelo::class, 1000)->create();
    }
}
