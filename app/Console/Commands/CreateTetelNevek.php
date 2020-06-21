<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateTetelNevek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:tetel-nevek';

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
        if(\App\TetelNev::count() > 0) {
            $this->error('A tétel nevek már le vannak generálva!');
        }
        else {
            $tetelek = [
                [
                    'nev' => 'A',
                ],
                [
                    'nev' => 'B',
                ],
                [
                    'nev' => 'F',
                ],
                [
                    'nev' => 'T',
                ],
                [
                    'nev' => 'L',
                ],
                [
                    'nev' => 'A m',
                ],
                [
                    'nev' => 'B m',
                ],
                [
                    'nev' => 'F m',
                ],
                [
                    'nev' => 'A1',
                ],
                [
                    'nev' => 'A2',
                ],
                [
                    'nev' => 'A3',
                ],
                [
                    'nev' => 'A4',
                ],
                [
                    'nev' => 'A5',
                ],
                [
                    'nev' => 'S1',
                ],
                [
                    'nev' => 'S2',
                ],
                [
                    'nev' => 'S3',
                ],
                [
                    'nev' => 'S4',
                ],
                [
                    'nev' => 'Dz',
                ],
            ];

            \App\TetelNev::insert($tetelek);
        }
    }
}
