<?php

namespace App\Console\Commands;

use App\TetelNev;
use Illuminate\Console\Command;

class SwapTetelNevSorrend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swap-sorrend:tetel-nev {nev1} {nev2}';
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
        $tetel1 = TetelNev::where('nev', $this->argument('nev1'))->first();
        $tetel2 = TetelNev::where('nev', $this->argument('nev2'))->first();
        $temp = $tetel1->sorrend;
        $tetel1->sorrend = $tetel2->sorrend;
        $tetel2->sorrend = $temp;
        $tetel1->save();
        $tetel2->save();
    }
}
