<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Http\Request;
use Password;

class CustomerResetPasswordController extends Controller
{
    use CanResetPassword;

    public function __construct()
    {
        $this->middleware('guest:customer');
    }

    // Use customer broker
    protected function broker()
    {
        return Password::broker('customers');
    }

    // After reset redirect
    protected $redirectTo = '/customer/dashboard';
}
