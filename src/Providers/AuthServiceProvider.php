<?php

namespace Softworx\RocXolid\UserManagement\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as IlluminateAuthServiceProvider;
use Softworx\RocXolid\CrudRouter;
use Softworx\RocXolid\UserManagement\Auth\Guard;
use Softworx\RocXolid\UserManagement\Auth\Middleware\Authenticate;
use Softworx\RocXolid\UserManagement\Auth\Middleware\RedirectIfAuthenticated;

/**
 * RocXolid authentication service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
class AuthServiceProvider extends IlluminateAuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    public function register()
    {
        $this->registerPolicies();
    }

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this
            ->setGuards()
            ->setRoutes($this->app['router']);
    }

    private function setGuards()
    {
        $this->app->config['auth.guards'] = $this->app->config['auth.guards'] + config('rocXolid.user-management.auth.guards');
        $this->app->config['auth.providers'] = $this->app->config['auth.providers'] + config('rocXolid.user-management.auth.providers');
// dd(__METHOD__);
        Auth::extend('rocXolid', function ($app, $name, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\Guard...
print_r($config);
            return new Guard(Auth::createUserProvider($config['provider']));
        });

        return $this;
    }

    private function setRoutes(Router $router)
    {
        $router->pushMiddlewareToGroup('rocXolid.guest', RedirectIfAuthenticated::class);
        $router->pushMiddlewareToGroup('rocXolid.auth', Authenticate::class);

        $router->group([
            'module' => 'rocXolid',
            'middleware' => [ 'web', 'rocXolid.guest' ],
            'namespace' => 'Softworx\RocXolid\UserManagement\Auth\Controllers',
            'prefix' => config('rocXolid.admin.general.routes.root', 'rocXolid'),
            'as' => 'rocXolid.auth.',
        ], function ($router) {
            $router->get(config('rocXolid.user-management.general.routes.login', 'login'), 'LoginController@index')->name('login');
            $router->post(config('rocXolid.user-management.general.routes.login', 'login'), 'LoginController@login')->name('login');
        });

        $router->group([
            'module' => 'rocXolid',
            'middleware' => [ 'web', 'rocXolid.auth' ],
            'namespace' => 'Softworx\RocXolid\UserManagement\Auth\Controllers',
            'prefix' => config('rocXolid.admin.general.routes.root', 'rocXolid'),
            'as' => 'rocXolid.auth.',
        ], function ($router) {
            $router->get(config('rocXolid.user-management.general.routes.logout', 'logout'), 'LoginController@logout')->name('logout');
            $router->get(config('rocXolid.user-management.general.routes.ping', 'ping'), 'LoginController@ping')->name('ping');
        });
    }
}
