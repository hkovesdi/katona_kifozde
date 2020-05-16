<?php

use Illuminate\Database\Seeder;

class MunkakorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('munkakorok')->insert([
            'nev' => "Kiszállító",
            'privilege_level' => 1,
        ]);

        DB::table('munkakorok')->insert([
            'nev' => "Bo$$",
            'privilege_level' => 5,
        ]);
    }
}
