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
        Schema::create('published_picklists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('p_picklist_sub_master_id');
            $table->foreign('p_picklist_sub_master_id')->references('id')->on('published_picklist_sub_masters')->onDelete('cascade');
            $table->unsignedBigInteger('size_id')->nullable();
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('set null');
            $table->integer('qty');
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