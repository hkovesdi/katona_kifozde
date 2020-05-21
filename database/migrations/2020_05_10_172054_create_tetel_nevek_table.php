<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTetelNevekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tetel_nevek', function (Blueprint $table) {
            $table->string('nev');
            $table->primary('nev');
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
        Schema::table('tetel_nevek', function (Blueprint $table) {
            $table->dropPrimary('tetel_nevek_nev_primary');
        });
        Schema::dropIfExists('tetel_nevek');
    }
}
