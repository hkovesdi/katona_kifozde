<?php

namespace App\Console\Commands;

use App\TetelNev;
use Illuminate\Console\Command;

class SetCorrectOrderForTetelNevek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:tetel-nevek';

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
        $tetelNevek = TetelNev::all();
        foreach($tetelNevek as $tetelNev) {
            $tetelNev->update(['sorrend' => $tetelNev->id]);
        }
    }
}
