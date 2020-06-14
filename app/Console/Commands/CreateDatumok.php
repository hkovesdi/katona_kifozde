<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CreateDatumok extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:datumok {--next-week}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elkészíti a dátumokat a következő hétre';

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
        $date = $this->option('next-week') != null ? Carbon::now()->addDays(7)->startOfWeek() : Carbon::now()->startOfWeek();
        $weekEndDate = $this->option('next-week') != null ? Carbon::now()->addDays(7)->endOfWeek() : Carbon::now()->endOfWeek();

        while($date->lte($weekEndDate)){
            if(!\App\Datum::where('datum', $date->format('Y-m-d'))->exists()) {
                \App\Datum::create([
                    'datum' => $date->format('Y-m-d'),
                    'het' => $date->weekOfYear,
                ]);
            }
            
            $date = $date->addDays(1);
        }
    }
}
