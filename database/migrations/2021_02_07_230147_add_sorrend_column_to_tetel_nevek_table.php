<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSorrendColumnToTetelNevekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tetel_nevek', function (Blueprint $table) {
            $table->integer('sorrend')->default(0);
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
            $table->dropColumn('sorrend');
        });
    }
}
