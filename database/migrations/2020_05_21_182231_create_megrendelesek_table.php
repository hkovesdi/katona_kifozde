<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMegrendelesekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('megrendelesek', function (Blueprint $table) {
            $table->id();

            $table->foreignId('megrendelo_het_id')->constrained('megrendelok_hetek')->onDelete("cascade");
            //$table->foreignId('megrendelo_id')->constrained('megrendelok');
            $table->foreignId('tetel_id')->constrained('tetelek')->onDelete("cascade");
           // $table->string('fizetesi_mod');
            //$table->foreign('fizetesi_mod')->references('nev')->on('fizetesi_modok');
            $table->boolean('feladag')->default(0);
            //$table->integer('fizetes_group');
            //$table->dateTime('fizetve_at')->nullable();
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
        Schema::table('megrendelesek', function (Blueprint $table) {
            $table->dropForeign(['tetel_id','megrendelo_het_id']);
        });
    }
}
