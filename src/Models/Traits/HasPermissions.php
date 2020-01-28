<?php

namespace Softworx\RocXolid\UserManagement\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
// rocXolid user management contracts
use Softworx\RocXolid\UserManagement\Models\Contracts\HasPermissions as HasPermissionsContract;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Permission;

/**
 * Trait to enable permissions for a model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
trait HasPermissions
{
    /**
     * {@inheritDoc}
     */
    public function permissions(): MorphToMany
    {
        return $this->morphToMany(Permission::class, 'model', 'model_has_permissions')->withoutGlobalScopes();
    }

    /**
     * {@inheritDoc}
     */
    public function givePermission(...$permissions): HasPermissionsContract
    {
        $this->permissions()->saveMany($permissions);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function syncPermissions(...$permissions): HasPermissionsContract
    {
        $this->permissions()->detach();

        return $this->givePermissionTo($permissions);
    }

    /**
     * {@inheritDoc}
     */
    public function revokePermission(Permission $permission): HasPermissionsContract
    {
        $this->permissions()->detach($permission);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function hasPermission(Permission $permission): bool
    {
        return $this->permissions->contains($permission);
    }

    /**
     * {@inheritDoc}
     */
    public function hasAnyPermission(...$permissions): bool
    {
        return collect($roles)->filter(function($role) {
            return $this->hasPermission($role);
        })->isNotEmpty();
    }

    /**
     * {@inheritDoc}
     */
    public function hasAllPermissions(...$permissions): bool
    {
        return collect($roles)->filter(function($role) {
            return !$this->hasPermission($role);
        })->isEmpty();
    }
}
