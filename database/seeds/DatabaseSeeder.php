<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        $this->call(MunkakorSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MegrendeloSeeder::class);
        $this->call(TetelNevSeeder::class);
        $this->call(DatumSeeder::class);
        $this->call(FizetesiModokSeeder::class);
        $this->call(TetelSeeder::class);
        $this->call(MegrendeloHetSeeder::class);
        $this->call(MegrendelesSeeder::class);
    }
}
