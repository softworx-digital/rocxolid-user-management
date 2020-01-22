<?php

namespace Softworx\RocXolid\UserManagement\Facades;

use Illuminate\Support\Facades\Facade;

class PermissionLoader extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'permission.loader';
    }
}
