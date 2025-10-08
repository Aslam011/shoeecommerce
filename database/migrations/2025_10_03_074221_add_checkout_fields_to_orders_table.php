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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_name')->nullable()->after('user_id');
            $table->string('customer_email')->nullable()->after('customer_name');
            $table->string('customer_phone')->nullable()->after('customer_email');
            $table->text('address')->nullable()->after('customer_phone');
            $table->string('city')->nullable()->after('address');
            $table->string('state')->nullable()->after('city');
            $table->string('postal_code')->nullable()->after('state');
            $table->string('country')->default('India')->after('postal_code');
            $table->string('address_type')->default('home')->after('country');
            $table->decimal('subtotal', 10, 2)->default(0)->after('total');
            $table->decimal('shipping', 10, 2)->default(0)->after('subtotal');
            $table->decimal('tax', 10, 2)->default(0)->after('shipping');
            $table->string('tracking_number')->nullable()->after('payment_method');
            $table->string('payment_status')->default('pending')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'customer_name',
                'customer_email',
                'customer_phone',
                'address',
                'city',
                'state',
                'postal_code',
                'country',
                'address_type',
                'subtotal',
                'shipping',
                'tax',
                'tracking_number',
                'payment_status',
            ]);
        });
    }
};
