<?php

namespace Softworx\RocXolid\UserManagement\Providers;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Illuminate\Support\Facades\Validator;
// third-party
use DvK\Laravel\Vat\Facades\Validator as VatValidator;

/**
 * rocXolid user management request validation service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid
 * @version 1.0.0
 */
class ValidationServiceProvider extends IlluminateServiceProvider
{
    /**
     * Extend the default request validator.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function boot()
    {
        Validator::extend('euvat', function ($attribute, $value, $parameters, $validator)
        {
            return empty($value) || VatValidator::validate($value);
        });

        return $this;
    }
}
