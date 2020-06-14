<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateFizetesiModok extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:fizetesi-modok';

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
        $fizetesiModok = [
            [
                'nev' => 'Készpénz'
            ],
            [
                'nev' => 'Bankkártya'
            ],
            [
                'nev' => 'Szépkártya'
            ],
            [
                'nev' => 'Baptista'
            ],
            [
                'nev' => 'Tartozás'
            ],
        ];

        if(\App\FizetesiMod::count() > 0) {
            $this->error('A fizetési módok már le vannak generálva!');
        }
        else {
            \App\FizetesiMod::insert($fizetesiModok);
        }
    }
}
