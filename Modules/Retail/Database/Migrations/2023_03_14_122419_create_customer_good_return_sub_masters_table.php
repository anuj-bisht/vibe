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
        Schema::create('customer_good_return_sub_masters', function (Blueprint $table) {
        
  $table->id();
  $table->unsignedBigInteger('cgood_return_master_id');
  $table->foreign('cgood_return_master_id')->references('id')->on('customer_good_return_masters')->onDelete('restrict');
  $table->unsignedBigInteger('product_id');
  $table->foreign('product_id')->references('id')->on('product_masters')->onDelete('restrict');
  $table->unsignedBigInteger('color_id');
  $table->foreign('color_id')->references('id')->on('colors')->onDelete('restrict');
  $table->integer('per_qty');
  $table->integer('total_qty');
  $table->integer('total_price');
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
        Schema::dropIfExists('customer_good_return_sub_masters');
    }
};
