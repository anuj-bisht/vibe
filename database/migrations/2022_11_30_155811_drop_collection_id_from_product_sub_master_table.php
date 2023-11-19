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
        Schema::table('product_sub_masters', function (Blueprint $table) {
            $table->dropForeign('product_sub_masters_collection_id_foreign');
            $table->dropColumn('collection_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_sub_masters', function (Blueprint $table) {
            //
        });
    }
};
