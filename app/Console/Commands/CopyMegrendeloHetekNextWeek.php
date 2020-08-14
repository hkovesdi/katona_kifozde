<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CopyMegrendeloHetekNextWeek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copy:megrendelo-hetek-next-week';

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
        $now = Carbon::now();
        $nextWeek = Carbon::now()->addWeek();

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
