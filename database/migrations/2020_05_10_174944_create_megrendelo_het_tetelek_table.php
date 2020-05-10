<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMegrendeloHetTetelekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('megrendelo_het_tetelek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('megrendelo_het_id')->constrained('megrendelok_hetek');
            $table->foreignId('tetel_id')->constrained('tetelek');
            $table->string('nap');
            $table->integer('mennyiseg');
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
        Schema::table('megrendelo_het_tetelek', function (Blueprint $table) {
            $table->dropForeign(['megrendelo_het_id','tetel_id']);
        });
        Schema::dropIfExists('megrendelo_het_tetelek');
    }
}
