<?php

namespace Softworx\RocXolid\UserManagement\Providers;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
// rocXolid user management package provider
use Softworx\RocXolid\UserManagement\ServiceProvider as PackageServiceProvider;

/**
 * rocXolid translation service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
class TranslationServiceProvider extends IlluminateServiceProvider
{
    /**
     * Bootstrap rocXolid translation services.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function boot()
    {
        $this
            ->load();

        return $this;
    }

    /**
     * Load translations.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    private function load()
    {
        $this->loadTranslationsFrom(PackageServiceProvider::translationsSourcePath(dirname(dirname(__DIR__))), 'rocXolid-user-management');

        return $this;
    }
}
