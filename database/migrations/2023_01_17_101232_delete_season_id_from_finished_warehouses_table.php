<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finished_warehouses', function (Blueprint $table) {
            $table->dropForeign('finished_warehouses_season_id_foreign');
            $table->dropColumn('season_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finished_warehouses', function (Blueprint $table) {
            //
        });
    }
};
