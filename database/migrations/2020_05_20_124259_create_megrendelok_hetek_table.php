<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMegrendelokHetekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('megrendelok_hetek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('megrendelo_id')->constrained('megrendelok')->onDelete("cascade");
            $table->foreignId('het_start_datum_id')->constrained('datumok')->onDelete("cascade");
            $table->string('fizetesi_mod');
            $table->foreign('fizetesi_mod')->references('nev')->on('fizetesi_modok')->onDelete("cascade");
            $table->dateTime('fizetve_at')->nullable();
            $table->string('megjegyzes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('megrendelok_hetek', function (Blueprint $table) {
            $table->dropForeign(['megrendelo_id', 'het_start_datum_id', 'fizetesi_mod']);
        });
    }
}
