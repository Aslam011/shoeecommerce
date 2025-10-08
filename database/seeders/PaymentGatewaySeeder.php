<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gateways = [
            [
                'name' => 'razorpay',
                'display_name' => 'Razorpay',
                'is_active' => false,
                'sort_order' => 1,
                'supports_upi' => true,
                'environment' => 'test',
            ],
            [
                'name' => 'phonepe',
                'display_name' => 'PhonePe',
                'is_active' => false,
                'sort_order' => 2,
                'supports_upi' => true,
                'environment' => 'test',
            ],
            [
                'name' => 'paytm',
                'display_name' => 'Paytm',
                'is_active' => false,
                'sort_order' => 3,
                'supports_upi' => true,
                'environment' => 'test',
            ],
            [
                'name' => 'cashfree',
                'display_name' => 'Cashfree',
                'is_active' => false,
                'sort_order' => 4,
                'supports_upi' => true,
                'environment' => 'test',
            ],
        ];

        foreach ($gateways as $gateway) {
            \App\Models\PaymentGateway::updateOrCreate(
                ['name' => $gateway['name']],
                $gateway
            );
        }
    }
}
