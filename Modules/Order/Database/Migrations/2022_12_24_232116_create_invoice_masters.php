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
        Schema::create('invoice_masters', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->string('regular');
            $table->timestamp('date');
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('order_masters')->onDelete('cascade');
            $table->unsignedBigInteger('picklist_id');
            $table->foreign('picklist_id')->references('id')->on('picklist_masters')->onDelete('cascade');
            $table->unsignedBigInteger('tax_id');
            $table->foreign('tax_id')->references('id')->on('taxes')->onDelete('cascade');
            $table->integer('total_pcs');
            $table->integer('discount');
            $table->integer('total_before_discount_tax');
            $table->integer('total_after_discount_tax');
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
        Schema::dropIfExists('');
    }
};
