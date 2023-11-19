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
        Schema::create('corporate_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_person_1');
            $table->string('designation_1');
            $table->string('mobile_no_1');
            $table->string('email_id_1');
            $table->string('contact_person_2');
            $table->string('designation_2');
            $table->string('mobile_no_2');
            $table->string('email_id_2');
            $table->string('contact_person_3');
            $table->string('designation_3');
            $table->string('mobile_no_3');
            $table->string('email_id_3');
            $table->string('billing_address');
            $table->string('billing_zip_code');
            $table->unsignedBigInteger('bcountry_id')->nullable();
            $table->foreign('bcountry_id')->references('id')->on('countries')->onDelete('set null');
            $table->unsignedBigInteger('bstate_id')->nullable();
            $table->foreign('bstate_id')->references('id')->on('states')->onDelete('set null');
            $table->unsignedBigInteger('bcity_id')->nullable();
            $table->foreign('bcity_id')->references('id')->on('cities')->onDelete('set null');
            $table->string('delivery_address');
            $table->string('delivery_zip_code');
            $table->unsignedBigInteger('dcountry_id')->nullable();
            $table->foreign('dcountry_id')->references('id')->on('countries')->onDelete('set null');
            $table->unsignedBigInteger('dstate_id')->nullable();
            $table->foreign('dstate_id')->references('id')->on('states')->onDelete('set null');
            $table->unsignedBigInteger('dcity_id')->nullable();
            $table->foreign('dcity_id')->references('id')->on('cities')->onDelete('set null');
            $table->string('gst_no');
            $table->string('credit_days');
            $table->string('credit_limit');
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('set null');
            $table->unsignedBigInteger('crm_id')->nullable();
            $table->foreign('crm_id')->references('id')->on('crms')->onDelete('set null');
            $table->unsignedBigInteger('commission_id')->nullable();
            $table->foreign('commission_id')->references('id')->on('commissions')->onDelete('set null');
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('set null');
            $table->unsignedBigInteger('transport_id')->nullable();
            $table->foreign('transport_id')->references('id')->on('transports')->onDelete('set null');
            $table->string('communication_via');
            $table->string('client_charge');
            $table->string('status');
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
        Schema::dropIfExists('corporate_profiles');
    }
};
