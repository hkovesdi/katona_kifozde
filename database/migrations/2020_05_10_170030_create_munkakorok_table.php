<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMunkakorokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('munkakorok', function (Blueprint $table) {
            $table->string('nev');
            $table->primary('nev');
            $table->integer('privilege_level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        Schema::table('munkakorok', function (Blueprint $table) {
            $table->dropPrimary('nev');
        });
        Schema::dropIfExists('munkakorok');
    }
}
