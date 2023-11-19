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
        Schema::create('customer_invoice_masters', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->timestamp('date');
            $table->unsignedBigInteger('order_id');
            $table->integer('total_pcs');
            $table->integer('discount');
            $table->integer('sub_total');
            $table->integer('grant_total');
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
        Schema::dropIfExists('customer_invoice_masters');
    }
};
