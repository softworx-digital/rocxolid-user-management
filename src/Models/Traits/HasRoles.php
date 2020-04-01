<?php

namespace Softworx\RocXolid\UserManagement\Models\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
// rocXolid user management model contracts
use Softworx\RocXolid\UserManagement\Models\Contracts\HasRoles as HasRolesContract;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Role;

/**
 * Trait to enable roles for a model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
trait HasRoles
{
    /**
     * {@inheritDoc}
     * @Softworx\RocXolid\Annotations\AuthorizedRelation(policy_abilities="['assign']")
     */
    public function roles(): MorphToMany
    {
        return $this->morphToMany(Role::class, 'model', 'model_has_roles');
    }

    public static function getSelfNonAssignableRoles()
    {
        return Role::where('is_self_assignable', 0)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function scopeRole(Builder $query, Collection $roles): Builder
    {
        return $query->whereHas('roles', function ($query) use ($roles) {
            $query->where(function ($query) use ($roles) {
                $roles->each(function ($role) use (&$query) {
                    $query->orWhere(sprintf('%s.%s', $role->getTable(), $role->getKeyName()), $role->getKey());
                });
            });
        });
    }

    /**
     * {@inheritDoc}
     */
    public function assignRole(...$roles): HasRolesContract
    {
        $this->roles()->saveMany($roles);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removeRole(Role $role): HasRolesContract
    {
        $this->roles()->detach($role);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function syncRoles(...$roles): HasRolesContract
    {
        $this->roles()->detach();

        return $this->assignRole($roles);
    }

    /**
     * {@inheritDoc}
     */
    public function hasRole(Role $role): bool
    {
        return $this->roles->contains($role);
    }

    /**
     * {@inheritDoc}
     */
    public function hasAnyRole(...$roles): bool
    {
        return collect($roles)->filter(function ($role) {
            return $this->hasRole($role);
        })->isNotEmpty();
    }

    /**
     * {@inheritDoc}
     */
    public function hasAllRoles(...$roles): bool
    {
        return collect($roles)->filter(function ($role) {
            return !$this->hasRole($role);
        })->isEmpty();
    }

    // @todo: "hotfixed"
    // should be in permissions
    public function isAdmin()
    {
        try {
            return $this->hasRole(Role::findOrFail(config('rocXolid.admin.auth.admin_role_id')));
        } catch (\Throwable $e) {
            dd('Setup Admin role ID in rocXolid.admin.auth.admin_role_id');
        }
    }
}
