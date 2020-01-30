<?php

namespace Softworx\RocXolid\UserManagement\Models\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
// rocXolid user management model contracts
use Softworx\RocXolid\UserManagement\Models\Contracts\HasRoles as HasRolesContract;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Role;

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

    /**
     * {@inheritDoc}
     */
    public function scopeRole(Builder $query, Collection $roles): Builder
    {
        return $query->whereHas('roles', function ($query) use ($roles) {
            $query->where(function ($query) use ($roles) {
                $roles->each(function ($role) use (&$query) {
                    $query->orWhere(sprintf('%s.%s', $role->getTable(), $role->getKeyName()), $role->id);
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
        return collect($roles)->filter(function($role) {
            return $this->hasRole($role);
        })->isNotEmpty();
    }

    /**
     * {@inheritDoc}
     */
    public function hasAllRoles(...$roles): bool
    {
        return collect($roles)->filter(function($role) {
            return !$this->hasRole($role);
        })->isEmpty();
    }
}
