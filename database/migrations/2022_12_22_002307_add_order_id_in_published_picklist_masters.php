<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('published_picklist_masters', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->after('client_id');
            $table->foreign('order_id')->references('id')->on('order_masters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('published_picklist_masters', function (Blueprint $table) {
            //
        });
    }
};
