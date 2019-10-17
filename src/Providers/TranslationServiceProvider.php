<?php

namespace Softworx\Rocxolid\UserManagement\Providers;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

/**
 * RocXolid translation service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
class TranslationServiceProvider extends IlluminateServiceProvider
{
    /**
     * Bootstrap RocXolid translation services.
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
        // customized translations preference
        // @TODO: doesn't quite work this way - either create custom translation loader and bind it to SL
        // @TODO: or publish to resources/lang/vendor/rocXolid:user-management
        // $this->loadTranslationsFrom(resource_path('lang/vendor/softworx/rocXolid/user-management'), 'rocXolid:user-management');

        // pre-defined translations fallback
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'rocXolid:user-management');

        return $this;
    }
}
