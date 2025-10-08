<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // razorpay, phonepe, paytm, cashfree
            $table->string('display_name'); // Razorpay, PhonePe, Paytm, Cashfree
            $table->boolean('is_active')->default(false);
            $table->text('api_key')->nullable();
            $table->text('api_secret')->nullable();
            $table->text('merchant_id')->nullable();
            $table->text('salt_key')->nullable(); // For PhonePe
            $table->text('salt_index')->nullable(); // For PhonePe
            $table->string('environment')->default('test'); // test or live
            $table->text('webhook_secret')->nullable();
            $table->json('additional_config')->nullable(); // For any extra configuration
            $table->integer('sort_order')->default(0);
            $table->boolean('supports_upi')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
