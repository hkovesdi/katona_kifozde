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
            $table->foreignId('het_id')->constrained('hetek');
            $table->foreignId('megrendelo_id')->constrained('megrendelok');
            $table->boolean('fizetett')->default(0);
            $table->boolean('szepkartya')->default(0);
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
            $table->dropForeign(['het_id','megrendelo_id']);
        });
        Schema::dropIfExists('megrendelok_hetek');
    }
}
