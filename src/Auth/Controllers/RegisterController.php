<?php

namespace Softworx\RocXolid\UserManagement\Auth\Controllers;

use Validator;
use Mail;
//use App\User;
//use App\Model\Email;
//use App\Http\Middleware\Admin\Role as RoleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Softworx\RocXolid\Http\Controllers\AbstractController;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('frontpage.auth.register');
    }

    public function redirectPath()
    {
        return route('frontpage.user.dashboard');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $config = config('laravel-permission.table_names');

        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => sprintf('required|email|max:255|unique:%s.users', (new User())->getConnection()->getName()),
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone_number' => '',
            'street_address' => '',
            'postal_code' => '',
            'city' => '',
            'activation_code' => '',
        ]);

        return $user;
    }

    protected function registered(Request $request, User $user)
    {
        $user->syncRoles([ RoleMiddleware::USER ]);

        $email = Email::findOrFail(Email::WELCOME);

        $data = [
            'body' => $email->parseBody([
                '[first-name]' => $user->first_name,
                '[email]' => $user->email,
                '[password]' => $request->input('password'),
            ]),
        ];

        Mail::send('notifications.email-custom', $data, function ($message) use ($email, $user, $data) {
            $message->from($email->sender);
            $message->subject($email->subject);
            $message->to($user->email);
        });
    }
}
