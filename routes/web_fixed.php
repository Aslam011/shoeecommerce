<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SliderController as AdminSliderController;
use App\Http\Controllers\Admin\PaymentGatewayController;
use App\Http\Controllers\AdminRegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Auth\CustomerLoginController;
use App\Http\Controllers\Auth\CustomerRegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Auth\CustomerForgotPasswordController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Api\EmailOtpController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop & Categories
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{category:slug}', [ShopController::class, 'index'])->name('shop.category');

// Product details - Using slug for SEO
Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('product.details');

// Search Routes with rate limiting
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/api/search/live', [SearchController::class, 'liveSearch'])
    ->middleware('throttle:20,1')
    ->name('search.live');

/*
|--------------------------------------------------------------------------
| Cart Routes
|--------------------------------------------------------------------------
*/
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/', [CartController::class, 'store'])->name('store');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::patch('/update-all', [CartController::class, 'updateAll'])->name('update.all');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    Route::post('/coupon', [CartController::class, 'applyCoupon'])->name('coupon');
});

/*
|--------------------------------------------------------------------------
| Checkout & Payment Routes
|--------------------------------------------------------------------------
*/
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('placeOrder');
    Route::post('/buy-now/{product}', [CheckoutController::class, 'buyNow'])->name('buy-now');
});

Route::prefix('payment')->name('payment.')->group(function () {
    Route::post('/initiate/{order}', [PaymentController::class, 'initiate'])->name('initiate');
    Route::get('/success/{order}', [PaymentController::class, 'success'])->name('success');
    Route::get('/failed/{order}', [PaymentController::class, 'failed'])->name('failed');
    
    // Webhook endpoints for payment gateways
    Route::post('/webhook/razorpay', [PaymentController::class, 'razorpayWebhook'])->name('webhook.razorpay');
    Route::post('/webhook/phonepe', [PaymentController::class, 'phonepeWebhook'])->name('webhook.phonepe');
    Route::post('/webhook/paytm', [PaymentController::class, 'paytmWebhook'])->name('webhook.paytm');
    Route::post('/webhook/cashfree', [PaymentController::class, 'cashfreeWebhook'])->name('webhook.cashfree');
});

/*
|--------------------------------------------------------------------------
| Customer Authentication
|--------------------------------------------------------------------------
*/
Route::prefix('customer')->name('customer.')->group(function () {
    // Register
    Route::get('/register', [CustomerRegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [CustomerRegisterController::class, 'register'])->name('register.submit');

    // OTP Verification with rate limiting
    Route::get('/verify-otp/{id}', [CustomerRegisterController::class, 'showOtpForm'])->name('verifyOtpForm');
    Route::post('/verify-otp/{id}', [CustomerRegisterController::class, 'verifyOtp'])
        ->middleware('throttle:5,1')
        ->name('verifyOtp');
    Route::post('/resend-otp/{id}', [CustomerRegisterController::class, 'resendOtp'])
        ->middleware('throttle:3,1')
        ->name('resendOtp');

    // Login & Logout
    Route::get('/login', [CustomerLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [CustomerLoginController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.submit');
    Route::post('/logout', [CustomerLoginController::class, 'logout'])->name('logout');

    // Password Reset
    Route::get('/forgot-password', [CustomerForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');
    Route::post('/forgot-password', [CustomerForgotPasswordController::class, 'sendResetLinkEmail'])
        ->middleware('throttle:3,10')
        ->name('password.email');
    Route::post('/verify-credentials', [CustomerForgotPasswordController::class, 'verifyCredentials'])
        ->middleware('throttle:5,1')
        ->name('verify.credentials');

    // Protected Customer Routes
    Route::middleware('auth:customer')->group(function () {
        Route::get('/dashboard', [CustomerLoginController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
        Route::get('/orders', [OrderController::class, 'myOrders'])->name('orders');
        Route::get('/orders/{order}', [OrderController::class, 'showCustomerOrder'])->name('orders.show');
        
        // Addresses
        Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
        Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
        Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Email OTP API Routes (with rate limiting)
|--------------------------------------------------------------------------
*/
Route::prefix('api/email-otp')->middleware('throttle:10,1')->group(function () {
    Route::post('/send', [EmailOtpController::class, 'sendOtp']);
    Route::post('/verify', [EmailOtpController::class, 'verifyOtp']);
    Route::post('/check-phone', [EmailOtpController::class, 'checkPhone']);
});

/*
|--------------------------------------------------------------------------
| Admin Authentication & Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // Register
    Route::get('/register', [AdminRegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AdminRegisterController::class, 'register'])->name('register.submit');

    // Login & Logout
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Protected Admin Routes
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Resource Controllers
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('sliders', AdminSliderController::class);
        
        // Payment Gateway Management
        Route::get('/payment-gateways', [PaymentGatewayController::class, 'index'])->name('payment-gateways.index');
        Route::post('/payment-gateways/{gateway}/toggle', [PaymentGatewayController::class, 'toggle'])->name('payment-gateways.toggle');
        Route::put('/payment-gateways/{gateway}', [PaymentGatewayController::class, 'update'])->name('payment-gateways.update');
    });
});

/*
|--------------------------------------------------------------------------
| Fallback Routes
|--------------------------------------------------------------------------
*/

// Default login route fallback
Route::get('/login', function () {
    return redirect()->route('customer.login');
})->name('login');

/*
|--------------------------------------------------------------------------
| Debug Routes (Local Environment Only)
|--------------------------------------------------------------------------
*/
if (app()->environment('local')) {
    Route::post('/debug-cart', function(\Illuminate\Http\Request $request) {
        \Log::info('Debug Cart Request:', $request->all());
        $cart = session('cart', []);
        \Log::info('Current session cart:', $cart);
        
        return response()->json([
            'request' => $request->all(),
            'session_cart' => $cart,
            'message' => 'Debug complete - check logs'
        ]);
    })->name('debug.cart');
}
