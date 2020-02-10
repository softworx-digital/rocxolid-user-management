<?php

namespace Softworx\RocXolid\UserManagement\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as IlluminateAuthServiceProvider;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid user management policies
use Softworx\RocXolid\UserManagement\Policies\CrudPolicy;
use Softworx\RocXolid\UserManagement\Policies\UserPolicy;
use Softworx\RocXolid\UserManagement\Policies\PermissionPolicy;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Permission;
use Softworx\RocXolid\UserManagement\Models\User;

/**
 * rocXolid user management authorization service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
class AuthServiceProvider extends IlluminateAuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Crudable::class => CrudPolicy::class,
        User::class => UserPolicy::class,
        Permission::class => PermissionPolicy::class,
    ];

    public function register()
    {
        $this->registerPolicies();
    }
}
