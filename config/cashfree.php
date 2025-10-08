<?php

return [
    'app_id' => env('CASHFREE_APP_ID'),
    'secret_key' => env('CASHFREE_SECRET_KEY'),
    'api_version' => env('CASHFREE_API_VERSION', '2023-08-01'),
    'environment' => env('CASHFREE_ENV', 'sandbox'),
    
    'api_base_url' => env('CASHFREE_ENV', 'sandbox') === 'production' 
        ? 'https://api.cashfree.com' 
        : 'https://sandbox.cashfree.com',
];
