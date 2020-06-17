<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKedvezmenyColumnToMegrendelokHetekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('megrendelok_hetek', function (Blueprint $table) {
            $table->integer('kedvezmeny')->default(0)->after('fizetesi_mod');
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
            $table->dropColumn('kedvezmeny');
        });
    }
}
