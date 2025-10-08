<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=================================\n";
echo "Registered Customers:\n";
echo "=================================\n\n";

$customers = DB::table('customers')->select('id', 'name', 'email', 'phone')->get();

if ($customers->count() > 0) {
    foreach ($customers as $customer) {
        echo "ID: {$customer->id}\n";
        echo "Name: {$customer->name}\n";
        echo "Email: {$customer->email}\n";
        echo "Phone: {$customer->phone}\n";
        echo "---------------------------------\n";
    }
    echo "\nTotal: {$customers->count()} customers\n";
} else {
    echo "No customers registered yet.\n";
}
