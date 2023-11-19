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
        Schema::create('cash_deposit_history', function (Blueprint $table) {
            $table->id();
            $table->date('cash_date');
            $table->integer('deposit_amount');
            $table->foreign('retail_id')->references('id')->on('corporate_profiles')->onDelete('restrict');
            $table->unsignedBigInteger('retail_id')->nullable();
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
        Schema::dropIfExists('cash_deposit_history');
    }
};
