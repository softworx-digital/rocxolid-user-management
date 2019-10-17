<?php

namespace Softworx\RocXolid\UserManagement\Auth\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Softworx\RocXolid\Http\Controllers\AbstractController;

/**
 * This controller is responsible for handling password reset requests
 * and uses a simple trait to include this behavior. You're free to
 * explore this trait and override any methods you wish to tweak.
 */
class ResetPasswordController extends AbstractController
{
    use ResetsPasswords;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('frontpage.auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function redirectPath()
    {
        return route('frontpage.user.dashboard');
    }
}
