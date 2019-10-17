<?php

namespace Softworx\RocXolid\UserManagement\Auth\Middleware;

use App;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Auth\Middleware\Authenticate as BaseAuthenticate;
use Illuminate\Auth\AuthenticationException as BaseAuthenticationException;
use Softworx\RocXolid\UserManagement\Auth\Exceptions\AuthenticationException;

/**
 * RocXolid authentication middleware.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
class Authenticate extends BaseAuthenticate
{
    /**
     * Create a new middleware instance.
     *
     * @param \Illuminate\Contracts\Auth\Factory $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
        $this->auth->shouldUse('rocXolid'); // guard definition
    }

    /**
     * {@inheritdoc}
     * @throws \Softworx\RocXolid\UserManagement\Auth\Exceptions\AuthenticationException
     */
    protected function authenticate($request, array $guards)
    {
        try {
            $user = parent::authenticate($request, $guards);

            if ($user->exists()) {
                $user->last_action = Carbon::now()->toDateTimeString();
                $user->logged_out = null;

                if (is_null($user->days_first_login) || !Carbon::parse($user->days_first_login)->isToday()) {
                    $user->days_first_login = Carbon::now()->toDateTimeString();
                }

                $user->save();

                App::setLocale($user->language->iso_639_1);
            }
        } catch (BaseAuthenticationException $e) {
            throw new AuthenticationException('Unauthenticated.', $guards, route('rocXolid.auth.login'));
        }

        return $user;
    }
}
