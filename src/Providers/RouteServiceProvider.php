<?php

namespace Softworx\Rocxolid\UserManagement\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Softworx\RocXolid\Services\CrudRouterService;

/**
 * rocXolid routes service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
class RouteServiceProvider extends IlluminateServiceProvider
{
    /**
     * Bootstrap rocXolid routing services.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function boot()
    {
        $this
            ->load($this->app->router);

        return $this;
    }

    /**
     * Define the routes for the package.
     *
     * @param  \Illuminate\Routing\Router $router Router to be used for routing.
     * @return \Illuminate\Support\ServiceProvider
     */
    private function load(Router $router): IlluminateServiceProvider
    {
        $router->group([
            'module' => 'rocXolid-user-management',
            'middleware' => [ 'web', 'rocXolid.auth' ],
            'namespace' => 'Softworx\RocXolid\UserManagement\Http\Controllers',
            'prefix' => sprintf('%s/user-management', config('rocXolid.main.admin-path', 'rocXolid')),
            'as' => 'rocXolid.user-management.',
        ], function ($router) {
            CrudRouterService::create('user', \User\Controller::class);
            CrudRouterService::create('group', \Group\Controller::class);
            CrudRouterService::create('role', \Role\Controller::class);
            CrudRouterService::create('permission', \Permission\Controller::class);
        });

        return $this;
    }
}
