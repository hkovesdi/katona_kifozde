<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateMunkakorok extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'munkakorok:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::table('munkakorok')->insert([
            'nev' => "Kiszállító",
            'privilege_level' => 1,
        ]);

        DB::table('munkakorok')->insert([
            'nev' => "Titkárnő",
            'privilege_level' => 5,
        ]);

        DB::table('munkakorok')->insert([
            'nev' => "Főnök",
            'privilege_level' => 5,
        ]);
    }
}
