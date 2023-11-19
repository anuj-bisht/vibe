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
        Schema::create('product_sub_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_master_id');
            $table->foreign('product_master_id')->references('id')->on('product_masters')->onDelete('cascade');
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('set null');
            $table->unsignedBigInteger('fabric_id')->nullable();
            $table->foreign('fabric_id')->references('id')->on('fabrics')->onDelete('set null');
            $table->unsignedBigInteger('style_id')->nullable();
            $table->foreign('style_id')->references('id')->on('styles')->onDelete('set null');
            $table->unsignedBigInteger('color_id')->nullable();
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('set null');
            $table->unsignedBigInteger('collection_id')->nullable();
            $table->foreign('collection_id')->references('id')->on('collections')->onDelete('set null');
            $table->unsignedBigInteger('margin_id')->nullable();
            $table->foreign('margin_id')->references('id')->on('margins')->onDelete('set null');
            $table->unsignedBigInteger('ean_id')->nullable();
            $table->foreign('ean_id')->references('id')->on('eans')->onDelete('set null');
            $table->unsignedBigInteger('hsn_id')->nullable();
            $table->foreign('hsn_id')->references('id')->on('hsns')->onDelete('set null');
            $table->unsignedBigInteger('fit_id')->nullable();
            $table->foreign('fit_id')->references('id')->on('fits')->onDelete('set null');
            $table->unsignedBigInteger('main_category_id')->nullable();
            $table->foreign('main_category_id')->references('id')->on('main_categories')->onDelete('set null');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('set null');
            $table->unsignedBigInteger('sub_sub_category_id')->nullable();
            $table->foreign('sub_sub_category_id')->references('id')->on('sub_sub_categories')->onDelete('set null');
            $table->string('type');
            $table->string('mrp');
            $table->string('cost_price');
            $table->string('description');
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
        Schema::dropIfExists('product_sub_masters');
    }
};
