<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CreateTetelek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tetelek:create {--next-week}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elkészíti a tételeket';

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
     * Legenerálja az üres (0ft) tételeket
     */
    private function initialCreate() 
    {   
        if(\App\Tetel::count() == 0) { 
            foreach(\App\Datum::all() as $datum) {
                if(Carbon::parse($datum->datum)->isWeekDay()) {
                    foreach(\App\TetelNev::all() as $tetelNev) {
                        \App\Tetel::create([
                            'tetel_nev' => $tetelNev->nev,
                            'datum_id' => $datum->id,
                            'ar' => 0,
                        ]);
                    }
                }
            }
        }
        else {
            $this->error('Tételek már léteznek');
        }
    }

    private function createNextWeek() {
        $datumok = \App\Datum::where('het', Carbon::now()->addDays(7)->weekOfYear)->get();

        foreach($datumok as $datum) {
            if(Carbon::parse($datum->datum)->isWeekDay()) {
                foreach(\App\TetelNev::all() as $tetelNev) {
                    $elozoHetiTetel = \App\Tetel::whereHas('datum', function($query) use($datum) {
                        $query->where('datum', Carbon::parse($datum->datum)->subDays(7));
                    })
                    ->where('tetel_nev', $tetelNev->nev)
                    ->first();

                    if($elozoHetiTetel !== null && !\App\Tetel::where('datum_id', $datum->id)->where('tetel_nev', $tetelNev->nev)->exists()) {
                        \App\Tetel::create([
                            'tetel_nev' => $tetelNev->nev,
                            'datum_id' => $datum->id,
                            'ar' => $elozoHetiTetel->ar,
                        ]);
                    }
                }
            }
        }
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        if($this->option('next-week')){
            $this->createNextWeek();
        }
        else {
            $this->initialCreate();
        }
    }
}
