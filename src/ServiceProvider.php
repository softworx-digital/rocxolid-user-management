<?php

namespace Softworx\RocXolid\UserManagement;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

/**
 * RocXolid Authentication, Authorization & User Management package service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Admin
 * @version 1.0.0
 */
class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(Providers\ConfigurationServiceProvider::class);
        $this->app->register(Providers\CommandServiceProvider::class);
        $this->app->register(Providers\AuthServiceProvider::class);
        $this->app->register(Providers\ViewServiceProvider::class);
        $this->app->register(Providers\RouteServiceProvider::class);
        $this->app->register(Providers\TranslationServiceProvider::class);
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
     * @return \Illuminate\Support\ServiceProvider
     */
    private function publish()
    {
        // config files
        // php artisan vendor:publish --provider="Softworx\RocXolid\UserManagement\ServiceProvider" --tag="config" (--force to overwrite)
        $this->publishes([
            __DIR__ . '/../config/general.php' => config_path('rocXolid/user-management/general.php'),
            __DIR__ . '/../config/auth.php' => config_path('rocXolid/user-management/auth.php'),
        ], 'config');

        // views files
        // php artisan vendor:publish --provider="Softworx\RocXolid\UserManagement\ServiceProvider" --tag="views" (--force to overwrite)
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/softworx/rocXolid/user-management'),
        ], 'views');

        // lang files
        // php artisan vendor:publish --provider="Softworx\RocXolid\UserManagement\ServiceProvider" --tag="views" (--force to overwrite)
        $this->publishes([
            //__DIR__ . '/../resources/lang' => resource_path('lang/vendor/softworx/rocXolid/user-management'),
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/rocXolid:user-management'),
        ], 'views');

        // migrations
        // php artisan vendor:publish --provider="Softworx\RocXolid\UserManagement\ServiceProvider" --tag="migrations" (--force to overwrite)
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');

        return $this;
    }
}