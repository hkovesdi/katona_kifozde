<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFizetesiModokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fizetesi_modok', function (Blueprint $table) {
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
        Schema::table('fizetesi_modok', function (Blueprint $table) {
            $table->dropPrimary('fizetesi_modok_nev_primary');
        });
        Schema::dropIfExists('fizetesi_modok');
    }
}
