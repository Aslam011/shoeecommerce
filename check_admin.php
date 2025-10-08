<?php
// Simple script to check admin table
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

echo "=== Admin Table Check ===\n\n";

try {
    $admins = Admin::all();
    
    if ($admins->count() > 0) {
        echo "Found " . $admins->count() . " admin(s):\n";
        foreach ($admins as $admin) {
            echo "- Email: {$admin->email}, Name: {$admin->name}\n";
        }
    } else {
        echo "No admins found in database.\n";
        echo "Creating default admin...\n\n";
        
        $admin = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        
        echo "✓ Admin created successfully!\n";
        echo "Email: admin@example.com\n";
        echo "Password: password\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
