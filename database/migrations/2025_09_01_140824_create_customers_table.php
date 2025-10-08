<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            // Core fields
            $table->string('name');
            $table->string('phone')->unique(); // phone used for login
            $table->string('password');

            // OTP verification
            $table->string('otp_code')->nullable();
            $table->boolean('is_verified')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
