<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMegrendelokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('megrendelok', function (Blueprint $table) {
            $table->id();
            $table->string('nev');
            $table->string('telefonszam');
            $table->string('szallitasi_cim');
            $table->foreignId('kiszallito_id')->constrained('users')->onDelete("cascade");
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
        Schema::table('megrendelok', function (Blueprint $table) {
            $table->dropForeign(['kiszallito_id']);
        });
        Schema::dropIfExists('megrendelok');
    }
}
