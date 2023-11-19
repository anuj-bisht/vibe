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
        Schema::create('grn_masters', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('validated');
            $table->string('grn_no'); 
            $table->unsignedBigInteger('retail_id'); 
            $table->foreign('retail_id')->references('id')->on('customers')->onDelete('restrict');
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
        Schema::dropIfExists('grn_masters');
    }
};
