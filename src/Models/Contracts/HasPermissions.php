<?php

namespace Softworx\RocXolid\UserManagement\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Permission;

/**
 * Interface to enable permissions for a model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
interface HasPermissions
{
    /**
     * A model permission relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function permissions(): MorphToMany;

    /**
     * Grant the given permission(s) to a model.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Permission $permissions,... Permissions to grant.
     * @return \Softworx\RocXolid\UserManagement\Models\Contracts\HasPermissions
     */
    public function givePermission(...$permissions): HasPermissions;

    /**
     * Remove all current permissions from model and set the given ones.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Permission $permissions,... Permissions to sync.
     * @return \Softworx\RocXolid\UserManagement\Models\Contracts\HasPermissions
     */
    public function syncPermissions(...$permissions): HasPermissions;

    /**
     * Revoke the given permission from model.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Permission $permission Permission to revoke.
     * @return \Softworx\RocXolid\UserManagement\Models\Contracts\HasPermissions
     */
    public function revokePermission(Permission $permission): HasPermissions;

    /**
     * Determine if the model has the given permission.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Permission $permission Permission to check.
     * @return bool
     */
    public function hasPermission(Permission $permissions): bool;

    /**
     * Determine if the model has any of the given permission(s).
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Permission,... $permissions Permissions to check.
     * @return bool
     */
    public function hasAnyPermission(...$permissions): bool;

    /**
     * Determine if the model has all of the given permission(s).
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Permission,... $permissions Permissions to check.
     * @return bool
     */
    public function hasAllPermissions(...$permissions): bool;
}
