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
        Schema::create('purchase_masters', function (Blueprint $table) {
            $table->id();  
            $table->unsignedBigInteger('warehouse_id'); 
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('restrict');
            $table->string('invoice_no');
            $table->string('regular');
            $table->timestamp('date');
            $table->unsignedBigInteger('client_id'); 
            $table->foreign('client_id')->references('id')->on('corporate_profiles')->onDelete('restrict');
            $table->unsignedBigInteger('tax_id');
            $table->foreign('tax_id')->references('id')->on('taxes')->onDelete('restrict');
            $table->integer('total_pcs');
            $table->integer('discount');
            $table->integer('discount_price');
            $table->integer('tax_price');
            $table->integer('sub_total');
            $table->integer('grand_total');
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
        Schema::dropIfExists('purchase_masters');
    }
};
