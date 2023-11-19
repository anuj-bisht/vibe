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
            $table->dropForeign('finished_warehouses_cutting_plan_id_foreign');
            $table->dropColumn('cutting_plan_id');
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
