<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTetelekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tetelek', function (Blueprint $table) {
            $table->id();
            $table->string('tetel_nev');
            $table->foreign('tetel_nev')->references('nev')->on('tetel_nevek')->onDelete("cascade");
            $table->foreignId('datum_id')->constrained('datumok')->onDelete("cascade");
            $table->string('leiras')->nullable();
            $table->integer('ar');
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
        Schema::table('tetelek', function (Blueprint $table) {
            $table->dropForeign(['tetel_nev','datum_id']);
        });
        Schema::dropIfExists('tetelek');
    }
}
