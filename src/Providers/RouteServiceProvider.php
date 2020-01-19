<?php

namespace Softworx\RocXolid\UserManagement\Providers;

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
            ->load($this->app->router)
            ->mapRouteModels($this->app->router);

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
            'prefix' => sprintf('%s/user-management', config('rocXolid.admin.general.routes.root', 'rocXolid')),
            'as' => 'rocXolid.user-management.',
        ], function ($router) {
            CrudRouterService::create('user', \User\Controller::class);
            CrudRouterService::create('user-profile', \UserProfile\Controller::class);
            CrudRouterService::create('company-profile', \CompanyProfile\Controller::class);
            CrudRouterService::create('group', \Group\Controller::class);
            CrudRouterService::create('role', \Role\Controller::class);

            $router->group([
                'namespace' => 'Permission',
                'prefix' => 'permission',
                'as' => 'permission.',
            ], function ($router) {
                $router->get('synchronize', 'Controller@synchronize')->name('synchronize');
            });

            CrudRouterService::create('permission', \Permission\Controller::class);
        });

        return $this;
    }

    /**
     * Define the route bindings for URL params.
     *
     * @param  \Illuminate\Routing\Router $router Router to be used for routing.
     * @return \Illuminate\Support\ServiceProvider
     */
    private function mapRouteModels(Router $router): IlluminateServiceProvider
    {
        $router->model('user', \Softworx\RocXolid\UserManagement\Models\User::class);
        $router->model('user_profile', \Softworx\RocXolid\UserManagement\Models\UserProfile::class);
        $router->model('company_profile', \Softworx\RocXolid\UserManagement\Models\CompanyProfile::class);
        $router->model('group', \Softworx\RocXolid\UserManagement\Models\Group::class);
        $router->model('permission', \Softworx\RocXolid\UserManagement\Models\Permission::class);
        $router->model('role', \Softworx\RocXolid\UserManagement\Models\Role::class);

        return $this;
    }
}
