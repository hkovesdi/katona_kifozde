<?php

use Illuminate\Database\Seeder;

class HetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        for($i = 0; $i < 30; $i++){
            \App\Het::create();
        }
    }
}
