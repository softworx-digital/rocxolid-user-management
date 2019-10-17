<?php

namespace Softworx\RocXolid\UserManagement\Auth\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class RedirectIfAuthenticated
{
    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
        $this->auth->shouldUse('rocXolid');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->auth->guard()->check()) {
            return redirect()->route('rocxolid.index');
        }

        return $next($request);
    }
}
