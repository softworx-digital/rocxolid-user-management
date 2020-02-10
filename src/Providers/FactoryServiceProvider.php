<?php

namespace Softworx\RocXolid\UserManagement\Providers;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

/**
 * rocXolid factory service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
class FactoryServiceProvider extends IlluminateServiceProvider
{
    /**
     * Boot factories.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function boot()
    {
        $this->loadFactoriesFrom(realpath(__DIR__ . '/../../database/factories'));

        return $this;
    }
}
