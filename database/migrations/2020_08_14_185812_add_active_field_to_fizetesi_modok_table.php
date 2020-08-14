<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActiveFieldToFizetesiModokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fizetesi_modok', function (Blueprint $table) {
            $table->boolean('active')->default(1)->after('nev');
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
            $table->dropColumn('active');
        });
    }
}
