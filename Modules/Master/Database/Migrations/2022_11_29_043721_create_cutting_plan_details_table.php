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
        Schema::create('cutting_plan_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cutting_plan_id');
            $table->foreign('cutting_plan_id')->references('id')->on('cutting_plans')->onDelete('cascade');
            $table->unsignedBigInteger('season_id')->nullable();
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('set null');
            $table->unsignedBigInteger('cutting_id')->nullable();
            $table->foreign('cutting_id')->references('id')->on('cuttings')->onDelete('set null');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
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
        Schema::dropIfExists('cutting_plan_details');
    }
};
