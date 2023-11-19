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
        Schema::create('retail_audit_sub_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('retail_audit_master_id');
            $table->foreign('retail_audit_master_id')->references('id')->on('retail_audit_masters')->onDelete('restrict');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('corporate_profiles')->onDelete('restrict');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('product_masters')->onDelete('restrict');
            $table->unsignedBigInteger('color_id');
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('restrict');
            $table->integer('total_qty');
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
        Schema::dropIfExists('retail_audit_sub_masters');
    }
};
