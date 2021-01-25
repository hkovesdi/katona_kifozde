<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MegrendeloHetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hetStartDatumok = DB::table("datumok")
            ->select(DB::raw("MIN(datum) as datum, het"))
            ->groupBy('het')
            ->get();
        
        $fizetesiModok = \App\FizetesiMod::where('nev', '!=', 'Tartozás')->get();
        
        foreach(\App\Megrendelo::all() as $megrendelo) {
            foreach($hetStartDatumok as $hetStartDatum){
                $datum = \App\Datum::where('datum', $hetStartDatum->datum)->first();
                $parsedDatum = \Carbon\Carbon::parse($datum->datum);
                if((bool)random_int(0,1)){
                    $futar = \App\User::where('munkakor', 'Kiszállító')->orWhere('munkakor', 'Szakács')->inRandomOrder()->first();
                    $elozo = \App\MegrendeloHet::where('kiszallito_id', $futar->id)->where('het_start_datum_id', $datum->id)->orderBy('sorrend', 'desc')->first();
                    \App\MegrendeloHet::create([
                        'megrendelo_id' => $megrendelo->id,
                        'het_start_datum_id' => $datum->id,
                        'fizetesi_mod' =>  $parsedDatum->weekOfYear == \Carbon\Carbon::now()->weekOfYear ? 'Tartozás' : $fizetesiModok->random()->nev,
                        'fizetve_at' => $parsedDatum->weekOfYear == \Carbon\Carbon::now()->weekOfYear ? NULL : $parsedDatum->addDays(random_int(1,4))->toDateTimeString(),
                        'kiszallito_id' => $futar->id,
                        'sorrend' => $elozo == null ? 1 : $elozo->sorrend+1,
                    ]);
                }
            }
        }
    }
}
