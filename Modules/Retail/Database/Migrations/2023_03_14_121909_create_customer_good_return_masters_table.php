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
        Schema::create('customer_good_return_masters', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no'); 
            $table->unsignedBigInteger('customer_id'); 
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict');
            $table->unsignedBigInteger('customer_invoice_master_id'); 
            $table->foreign('customer_invoice_master_id')->references('id')->on('customer_invoice_masters')->onDelete('restrict');
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
        Schema::dropIfExists('customer_good_return_masters');
    }
};
