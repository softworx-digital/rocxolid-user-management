<?php

namespace Softworx\RocXolid\UserManagement\Models\Contracts;

// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid user management model contracts
use Softworx\RocXolid\UserManagement\Models\Contracts\HasRoles;
use Softworx\RocXolid\UserManagement\Models\Contracts\HasPermissions;
use Softworx\RocXolid\UserManagement\Models\Contracts\HasRolePermissions;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Permission;

/**
 * Interface to retrieve permission for a model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
interface HasAuthorization extends HasRoles, HasPermissions, HasRolePermissions
{
    /**
     * Get permission for given ability, model class and attribute.
     *
     * @param string $ability
     * @param string $model_class
     * @param string $attribute
     * @return \Softworx\RocXolid\UserManagement\Models\Permission|null
     */
    public function getPermissionFor(
        string $ability,
        string $model_class,
        ?string $attribute = null
    ): ?Permission;

    /**
     * Check if permission is allowed in permission's scope.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Permission $permission
     * @param string $ability
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param string $forced_scope_type
     * @return bool
     */
    public function allowPermission(
        Permission $permission,
        string $ability,
        ?Crudable $model = null,
        ?string $forced_scope_type = null
    ): bool;
}
