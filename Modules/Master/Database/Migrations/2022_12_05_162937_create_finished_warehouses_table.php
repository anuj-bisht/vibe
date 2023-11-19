<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finished_warehouses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('warehouse_id');
            $table->foreign('warehouse_id')->references('id')->on('finished_warehouses')->onDelete('cascade');
            $table->unsignedBigInteger('cutting_plan_id')->nullable();
            $table->foreign('cutting_plan_id')->references('id')->on('cutting_plans')->onDelete('set null');
            $table->unsignedBigInteger('product_master_id')->nullable();
            $table->foreign('product_master_id')->references('id')->on('product_masters')->onDelete('set null');
            $table->integer('sum');
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
        Schema::dropIfExists('finished_warehouses');
    }
};
