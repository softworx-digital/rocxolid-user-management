<?php

namespace Softworx\RocXolid\UserManagement;

use Illuminate\Foundation\AliasLoader;
// rocXolid service providers
use Softworx\RocXolid\AbstractServiceProvider as RocXolidAbstractServiceProvider;

/**
 * rocXolid Authentication, Authorization & User Management package primary service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
class ServiceProvider extends RocXolidAbstractServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(Providers\ConfigurationServiceProvider::class);
        $this->app->register(Providers\AuthServiceProvider::class);
        $this->app->register(Providers\ViewServiceProvider::class);
        $this->app->register(Providers\RouteServiceProvider::class);
        $this->app->register(Providers\TranslationServiceProvider::class);
        $this->app->register(Providers\FacadeServiceProvider::class);
        $this->app->register(Providers\FactoryServiceProvider::class);

        $this
            ->bindContracts()
            ->bindAliases(AliasLoader::getInstance());
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this
            ->publish();
    }

    /**
     * Bind contracts / facades, so they don't have to be added to config/app.php.
     *
     * Usage:
     *      $this->app->bind(<SomeContract>::class, <SomeImplementation>::class);
     *
     * @return \Softworx\RocXolid\AbstractServiceProvider
     */
    private function bindContracts(): RocXolidAbstractServiceProvider
    {
        $this->app->bind('policy.scope.all', Policies\Scopes\All::class);
        $this->app->bind('policy.scope.owned', Policies\Scopes\Owned::class);

        return $this;
    }

    /**
     * Bind aliases, so they don't have to be added to config/app.php.
     *
     * Usage:
     *      $loader->alias('<alias>', <Facade/>Contract>::class);
     *
     * @return \Softworx\RocXolid\AbstractServiceProvider
     */
    private function bindAliases(AliasLoader $loader): RocXolidAbstractServiceProvider
    {
        // rocXolid
        $loader->alias('PermissionLoader', Facades\PermissionLoader::class);
        // third-party
        // ...

        return $this;
    }
}
