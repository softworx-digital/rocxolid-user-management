<?php

namespace Softworx\RocXolid\UserManagement\Models\Contracts;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Role;

/**
 * Interface to enable roles for a model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
interface HasRoles
{
    /**
     * A model role relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function roles(): MorphToMany;

    /**
     * Scope the model query to certain roles only.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Support\Collection $roles Roles to allow.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRole(Builder $query, Collection $roles): Builder;

    /**
     * Assign the given role to the model.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Role,... $roles Roles to assign.
     * @return \Softworx\RocXolid\UserManagement\Models\Contracts\HasRoles
     */
    public function assignRole(...$roles): HasRoles;

    /**
     * Remove all current roles and set the given ones.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Role,... $roles Roles to sync.
     * @return \Softworx\RocXolid\UserManagement\Models\Contracts\HasRoles
     */
    public function syncRoles(...$roles): HasRoles;

    /**
     * Revoke the given role from the model.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Role $role Role to revoke.
     * @return \Softworx\RocXolid\UserManagement\Models\Contracts\HasRoles
     */
    public function removeRole(Role $role): HasRoles;

    /**
     * Determine if the model has the given role.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Role $role Role to check.
     * @return bool
     */
    public function hasRole(Role $role): bool;

    /**
     * Determine if the model has any of the given role(s).
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Role,... $roles Roles to check.
     * @return bool
     */
    public function hasAnyRole(...$roles): bool;

    /**
     * Determine if the model has all of the given role(s).
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Role,... $roles Roles to check.
     * @return bool
     */
    public function hasAllRoles(...$roles): bool;
}
