<?php

namespace Softworx\RocXolid\UserManagement\Providers;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
// rocXolid user management services
use Softworx\RocXolid\UserManagement\Services\PermissionLoaderService;

/**
 * rocXolid user management facades service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
class FacadeServiceProvider extends IlluminateServiceProvider
{
    /**
     * Register rocXolid facades.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function register(): IlluminateServiceProvider
    {
        $this->app->singleton('permission.loader', function () {
            return $this->app->make(PermissionLoaderService::class);
        });

        return $this;
    }
}
