<?php

namespace App\Console\Commands;

use App\TetelNev;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CreateNewTetelNev extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:tetel-nev {nev} {sorrend}';

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
        $nev = $this->argument('nev');
        $sorrend = $this->argument('sorrend');
        if(!TetelNev::where('nev', $nev)->exists()) {
            TetelNev::create([
                'nev' => $nev,
                'sorrend' => $sorrend
            ]);
            if(TetelNev::where('sorrend', $sorrend)->where('nev', '!=', $nev)->exists()) {
                TetelNev::where('sorrend', '>=', $sorrend)
                    ->where('nev', '!=', $nev)
                    ->each(function($tetelNev) {
                        $tetelNev->update(['sorrend' => $tetelNev->sorrend + 1]);
                });
            }
            foreach(\App\Datum::whereDate('datum', '>=', Carbon::now()->startOfWeek())->whereDate('datum', '<=', Carbon::now()->endOfWeek())->get() as $datum) {
                if(Carbon::parse($datum->datum)->isWeekDay()) {
                    \App\Tetel::create([
                        'tetel_nev' => $nev,
                        'datum_id' => $datum->id,
                        'ar' => 0,
                    ]);
                }
            }
        }
    }
}
