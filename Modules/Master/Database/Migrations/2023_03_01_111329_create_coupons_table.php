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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_type');
            $table->string('coupon_title');
            $table->string('coupon_code');
            $table->integer('limit_user');
            $table->string('discount_type');
            $table->integer('discount_amount');
            $table->integer('minimum_purchase');
            $table->integer('maximum_discount');
            $table->date('start_date');
            $table->date('expire_date');
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
        Schema::dropIfExists('coupons');
    }
};
