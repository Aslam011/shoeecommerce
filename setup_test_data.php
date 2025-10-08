<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Creating test data...\n\n";

// Create a test customer
$customer = App\Models\Customer::create([
    'name' => 'Test Customer',
    'first_name' => 'Test',
    'last_name' => 'Customer',
    'email' => 'test@example.com',
    'phone' => '9876543210',
    'password' => bcrypt('password'),
    'email_verified_at' => now(),
]);
echo "✅ Customer created: ID #{$customer->id}\n";

// Create a test product
$category = App\Models\Category::create([
    'name' => 'Test Shoes',
    'slug' => 'test-shoes',
    'description' => 'Test category',
]);

$product = App\Models\Product::create([
    'name' => 'Test Shoe Product',
    'slug' => 'test-shoe-product',
    'description' => 'A test product for Cashfree testing',
    'price' => 100.00,
    'stock' => 50,
    'category_id' => $category->id,
]);
echo "✅ Product created: ID #{$product->id} - Price: ₹{$product->price}\n";

// Seed payment gateways
$gateways = [
    ['name' => 'cashfree', 'display_name' => 'Cashfree', 'is_active' => true, 'sort_order' => 1],
    ['name' => 'razorpay', 'display_name' => 'Razorpay', 'is_active' => false, 'sort_order' => 2],
    ['name' => 'phonepe', 'display_name' => 'PhonePe', 'is_active' => false, 'sort_order' => 3],
];

foreach ($gateways as $gateway) {
    App\Models\PaymentGateway::create($gateway);
}
echo "✅ Payment gateways created\n";

echo "\n✅ Test data setup complete!\n";
echo "\nTest Credentials:\n";
echo "Email: test@example.com\n";
echo "Password: password\n";
echo "\nNow you can login and test the Cashfree payment!\n";
