<?php

namespace Softworx\RocXolid\UserManagement\Models\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
// rocXolid user management model contracts
use Softworx\RocXolid\UserManagement\Models\Contracts\HasGroups as HasGroupsContract;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Group;

/**
 * Trait to enable groups for a model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
trait HasGroups
{
    /**
     * {@inheritDoc}
     * @Softworx\RocXolid\Annotations\AuthorizedRelation(policy_abilities="['assign']")
     */
    public function groups(): MorphToMany
    {
        return $this->morphToMany(Group::class, 'model', 'model_has_groups');
    }

    /**
     * {@inheritDoc}
     */
    public function scopeGroup(Builder $query, Collection $groups): Builder
    {
        return $query->whereHas('groups', function ($query) use ($groups) {
            $query->where(function ($query) use ($groups) {
                $roles->each(function ($group) use (&$query) {
                    $query->orWhere(sprintf('%s.%s', $group->getTable(), $group->getKeyName()), $group->id);
                });
            });
        });
    }

    /**
     * {@inheritDoc}
     */
    public function assignGroup(...$groups): HasGroupsContract
    {
        $this->groups()->saveMany($groups);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removeFromGroup(Group $group): HasGroupsContract
    {
        $this->groups()->detach($group);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function syncGroups(...$groups): HasGroupsContract
    {
        $this->groups()->detach();

        return $this->assignGroup($groups);
    }

    /**
     * {@inheritDoc}
     */
    public function hasGroup(Group $group): bool
    {
        return $this->groups->contains($group);
    }

    /**
     * {@inheritDoc}
     */
    public function hasAnyGroup(...$groups): bool
    {
        return collect($groups)->filter(function($group) {
            return $this->hasGroup($group);
        })->isNotEmpty();
    }

    /**
     * {@inheritDoc}
     */
    public function hasAllGroups(...$groups): bool
    {
        return collect($groups)->filter(function($group) {
            return !$this->hasGroup($group);
        })->isEmpty();
    }
}
