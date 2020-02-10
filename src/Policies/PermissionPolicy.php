<?php

namespace Softworx\RocXolid\UserManagement\Policies;

// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid user management contracts
use Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization;
// rocXolid user management policies
use Softworx\RocXolid\UserManagement\Policies\CrudPolicy;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Permission;

/**
 * Permission controller/model policy.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
class PermissionPolicy extends CrudPolicy
{
    /**
     * Determine whether the user can do permission synchronization.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization $user
     * @return bool
     */
    public function synchronize(HasAuthorization $user): bool
    {
        return $this->checkPermissions($user, 'synchronize', Permission::class);
    }
}
