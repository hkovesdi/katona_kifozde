<?php

namespace App\Console\Commands;

use App\Munkakor;
use Illuminate\Console\Command;

class CreateSzakacsRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:szakacs-role';

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
        if(!Munkakor::where('nev', 'Szakács')->exists()) {
            Munkakor::create(['nev' => 'Szakács', 'privilege_level' => 2]);
        }
    }
}
