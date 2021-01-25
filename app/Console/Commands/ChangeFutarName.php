<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ChangeFutarName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:futar-name';

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
        User::where('nev', 'Hunka Virág')->update(['nev' => 'Szalai Richárd']);
        User::where('nev', 'Wéber Dominik')->update(['nev' => 'Wéber Tamás', 'munkakor' => 'Szakács', 'password' => Hash::make('Kiskakas2021')]);
    }
}
