<?php

namespace Softworx\RocXolid\UserManagement\Models\Contracts;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Group;

/**
 * Interface to enable groups for a model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
interface HasGroups
{
    /**
     * A model group relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function groups(): MorphToMany;

    /**
     * Scope the model query to certain groups only.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Support\Collection $groups Groups to allow.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGroup(Builder $query, Collection $groups): Builder;

    /**
     * Assign the given group to the model.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Group,... $groups Groups to assign.
     * @return \Softworx\RocXolid\UserManagement\Models\Contracts\HasGroups
     */
    public function assignGroup(...$groups): HasGroups;

    /**
     * Remove all current groups and set the given ones.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Group,... $groups Groups to sync.
     * @return \Softworx\RocXolid\UserManagement\Models\Contracts\HasGroups
     */
    public function syncGroups(...$groups): HasGroups;

    /**
     * Revoke the given group from the model.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Group $group Group to revoke.
     * @return \Softworx\RocXolid\UserManagement\Models\Contracts\HasGroups
     */
    public function removeFromGroup(Group $group): HasGroups;

    /**
     * Determine if the model has the given group.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Group $group Group to check.
     * @return bool
     */
    public function hasGroup(Group $group): bool;

    /**
     * Determine if the model has any of the given group(s).
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Group,... $groups Groups to check.
     * @return bool
     */
    public function hasAnyGroup(...$groups): bool;

    /**
     * Determine if the model has all of the given group(s).
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Group,... $groups Groups to check.
     * @return bool
     */
    public function hasAllGroups(...$groups): bool;
}
