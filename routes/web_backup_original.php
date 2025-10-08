<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SliderController as AdminSliderController;
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
use App\Http\Controllers\Auth\CustomerResetPasswordController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Api\EmailOtpController;
use App\Http\Controllers\SearchController;

Route::post('/addresses', [App\Http\Controllers\AddressController::class, 'store'])
    ->name('addresses.store');

Route::middleware(['auth:customer'])->group(function () {
    Route::post('/addresses', [App\Http\Controllers\Auth\AddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{id}', [App\Http\Controllers\Auth\AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{id}', [App\Http\Controllers\Auth\AddressController::class, 'destroy'])->name('addresses.destroy');
});


// Customer Password Reset Routes
Route::prefix('customer')->name('customer.')->group(function () {
    // Request link form
    Route::get('forgot-password', [CustomerForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');

    // Send link email (now direct password reset)
    Route::post('forgot-password', [CustomerForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');

    // API endpoint to verify email and phone combination
    Route::post('verify-credentials', [CustomerForgotPasswordController::class, 'verifyCredentials'])
        ->name('verify.credentials');
});

use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/register', [RegisteredUserController::class, 'create'])
        ->middleware('guest')
        ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('guest');

Route::get('/customer/password/reset', [CustomerForgotPasswordController::class, 'showLinkRequestForm'])->name('customer.password.request');
Route::post('/customer/password/email', [CustomerForgotPasswordController::class, 'sendResetLinkEmail'])->name('customer.password.email');

// Your existing cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');

// Add these new routes
Route::patch('/cart/update-all', [CartController::class, 'updateAll'])->name('cart.update.all');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon');

// Checkout route
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::get('customer/orders/{order}', [OrderController::class, 'showCustomerOrder'])
    ->name('customer.orders.show');

Route::get('shop/{category}', [ShopController::class, 'index'])->name('shop.category');

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Email OTP API Routes
Route::prefix('api/email-otp')->group(function () {
    Route::post('/send', [EmailOtpController::class, 'sendOtp']);
    Route::post('/verify', [EmailOtpController::class, 'verifyOtp']);
    Route::post('/check-phone', [EmailOtpController::class, 'checkPhone']);
});

// Search Routes
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/api/search/live', [SearchController::class, 'liveSearch'])->name('search.live');

// API Routes
Route::post('/debug-cart', function(Request $request) {
    \Log::info('Debug Cart Request:', $request->all());

    $cart = session('cart', []);
    \Log::info('Current session cart:', $cart);

    return response()->json([
        'request' => $request->all(),
        'session_cart' => $cart,
        'message' => 'Debug complete - check logs'
    ]);
})->name('debug.cart');
// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop & Categories
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{category:slug}', [ShopController::class, 'index'])->name('shop.category');

// Product details
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.details');

// Cart
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/', [CartController::class, 'store'])->name('store');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});

// Checkout
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('placeOrder');
    Route::post('/buy-now/{product}', [CheckoutController::class, 'buyNow'])->name('buy-now');
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

    // OTP Verification
    Route::get('/verify-otp/{id}', [CustomerRegisterController::class, 'showOtpForm'])->name('verifyOtpForm');
    Route::post('/verify-otp/{id}', [CustomerRegisterController::class, 'verifyOtp'])->name('verifyOtp');
    Route::post('/resend-otp/{id}', [CustomerRegisterController::class, 'resendOtp'])->name('resendOtp');

    // Login & Logout
    Route::get('/login', [CustomerLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [CustomerLoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [CustomerLoginController::class, 'logout'])->name('logout');

    // Protected Routes
    Route::middleware('auth:customer')->group(function () {
        Route::get('/dashboard', [CustomerLoginController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
        Route::get('/orders', [OrderController::class, 'myOrders'])->name('orders');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Authentication
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

    // Protected Routes
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('sliders', AdminSliderController::class);
    });
});

/*
|--------------------------------------------------------------------------
| Default Fallbacks
|--------------------------------------------------------------------------
*/

// Default login route fallback
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// Payment routes
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/{order}/{method}', [CheckoutController::class, 'showPayment'])->name('process');
});
