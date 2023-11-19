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
        Schema::table('picklist_masters', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->after('state_id');
            $table->foreign('client_id')->references('id')->on('corporate_profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('picklist_masters', function (Blueprint $table) {
            //
        });
    }
};
