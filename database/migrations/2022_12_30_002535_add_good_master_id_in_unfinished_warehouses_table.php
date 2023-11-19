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
        Schema::table('unfinished_warehouses', function (Blueprint $table) {
            $table->unsignedBigInteger('good_master_id')->after('id');
            $table->foreign('good_master_id')->references('id')->on('goods_masters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unfinished_warehouses', function (Blueprint $table) {
            //
        });
    }
};
