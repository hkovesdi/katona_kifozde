<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateEverythingTwoWeeks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:everything-two-weeks';

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
        $date = Carbon::now()->addDays(14)->startOfWeek();
        $weekEndDate = Carbon::now()->addDays(14)->endOfWeek();

        while($date->lte($weekEndDate)){
            if(!\App\Datum::where('datum', $date->format('Y-m-d'))->exists()) {
                \App\Datum::create([
                    'datum' => $date->format('Y-m-d'),
                    'het' => $date->weekOfYear,
                ]);
            }
            
            $date = $date->addDays(1);
        }

        $datumok = \App\Datum::where('het', Carbon::now()->addDays(14)->weekOfYear)->get();

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

        $now = Carbon::now()->addWeek();
        $nextWeek = Carbon::now()->addWeeks(2);

        \App\MegrendeloHet::whereHas('datum', function($query) use($now) {
            $query->whereYear('datum', $now->year)->where('het', $now->weekOfYear);
        })
        ->orderBy('sorrend')
        ->get()
        ->groupBy('kiszallito_id')
        ->each(function($kiszallitoMegrendeloHetek, $kiszallitoId) use($nextWeek) {
            $existingMegrendeloHetCount = \App\MegrendeloHet::where('kiszallito_id', $kiszallitoId)
            ->whereHas('datum', function($query) use($nextWeek) {
                $query->whereYear('datum', $nextWeek->year)->where('het', $nextWeek->weekOfYear);
            })
            ->count();
            $kiszallitoMegrendeloHetek->each(function($megrendeloHet) use($nextWeek, &$existingMegrendeloHetCount){
                $megrendeloHetExistsNextWeek = \App\MegrendeloHet::where('megrendelo_id', $megrendeloHet->megrendelo_id)
                ->where('kiszallito_id', $megrendeloHet->kiszallito_id)
                ->whereHas('datum', function($query) use($nextWeek) {
                    $query->whereYear('datum', $nextWeek->year)->where('het', $nextWeek->weekOfYear);
                })
                ->exists();
    
                if(!$megrendeloHetExistsNextWeek) {
                    \App\MegrendeloHet::create([
                        'megrendelo_id' => $megrendeloHet->megrendelo_id,
                        'kiszallito_id' => $megrendeloHet->kiszallito_id,
                        'kedvezmeny' => $megrendeloHet->kedvezmeny,
                        'sorrend' => ++$existingMegrendeloHetCount,
                        'het_start_datum_id' => \App\Datum::whereYear('datum', $nextWeek->year)->where('het', $nextWeek->weekOfYear)->first()->id,
                        'fizetesi_mod' => "Tartozás"
                    ]);
                }
            });
        });
    }
}
