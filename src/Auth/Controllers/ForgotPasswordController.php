<?php

namespace Softworx\RocXolid\UserManagement\Auth\Controllers;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Softworx\RocXolid\Http\Controllers\AbstractController;

class ForgotPasswordController extends AbstractController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
        return view('frontpage.auth.passwords.request');
    }
}
