<?php

namespace Softworx\RocXolid\UserManagement;

use Illuminate\Foundation\AliasLoader;
use Softworx\RocXolid\AbstractServiceProvider as RocXolidAbstractServiceProvider;

/**
 * rocXolid Authentication, Authorization & User Management package service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Admin
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

        $this->app->bind('policy.scope.all', Policies\Scopes\All::class);
        $this->app->bind('policy.scope.owned', Policies\Scopes\Owned::class);

        $this
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
     * Expose config files and resources to be published.
     *
     * @return \Softworx\RocXolid\AbstractServiceProvider
     */
    private function publish(): RocXolidAbstractServiceProvider
    {
        // config files
        // php artisan vendor:publish --provider="Softworx\RocXolid\UserManagement\ServiceProvider" --tag="config" (--force to overwrite)
        $this->publishes([
            __DIR__ . '/../config/general.php' => config_path('rocXolid/user-management/general.php'),
        ], 'config');

        // lang files
        // php artisan vendor:publish --provider="Softworx\RocXolid\UserManagement\ServiceProvider" --tag="lang" (--force to overwrite)
        $this->publishes([
            //__DIR__ . '/../resources/lang' => resource_path('lang/vendor/softworx/rocXolid/user-management'),
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/rocXolid:user-management'),
        ], 'lang');

        // views files
        // php artisan vendor:publish --provider="Softworx\RocXolid\UserManagement\ServiceProvider" --tag="views" (--force to overwrite)
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/softworx/rocXolid/user-management'),
        ], 'views');

        // migrations
        // php artisan vendor:publish --provider="Softworx\RocXolid\UserManagement\ServiceProvider" --tag="migrations" (--force to overwrite)
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
        ], 'migrations');

        return $this;
    }

    /**
     * Bind aliases, so they don't have to be added to config/app.php.
     *
     * Template:
     *      $loader->alias('<alias>', <Facade/Contract>::class);
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
