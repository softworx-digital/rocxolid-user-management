<?php

namespace Softworx\RocXolid\UserManagement\Models\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Softworx\RocXolid\UserManagement\Models\Group;

trait HasGroups
{
    /**
     * A model may have multiple groups.
     */
    public function groups(): MorphToMany
    {
        return $this->morphToMany(
            Group::class,
            'model',
            'model_has_groups',
            'model_id',
            'group_id'
        );
    }

    /**
     * Scope the model query to certain groups only.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array|Group|\Illuminate\Support\Collection $groups
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGroup(Builder $query, $groups): Builder
    {
        if ($groups instanceof Collection)
        {
            $groups = $groups->toArray();
        }

        if (!is_array($groups))
        {
            $groups = [$groups];
        }

        $groups = array_map(function ($group)
        {
            if ($group instanceof Group)
            {
                return $group;
            }

            return app(Group::class)->findByName($group, $this->getDefaultGuardName());
        },
        $groups);

        return $query->whereHas('groups', function ($query) use ($groups)
        {
            $query->where(function ($query) use ($groups)
            {
                foreach ($groups as $group)
                {
                    $query->orWhere('groups.id', $group->id);
                }
            });
        });
    }

    /**
     * Assign the given group to the model.
     *
     * @param array|string|\Spatie\Permission\Contracts\Group ...$groups
     *
     * @return $this
     */
    public function assignGroup(...$groups)
    {
        $groups = collect($groups)
            ->flatten()
            ->map(function ($group)
            {
                return $this->getStoredGroup($group);
            })
            ->each(function ($group)
            {
                $this->ensureModelSharesGuard($group);
            })
            ->all();

        $this->groups()->saveMany($groups);

        $this->forgetCachedPermissions();

        return $this;
    }

    /**
     * Revoke the given group from the model.
     *
     * @param string|\Spatie\Permission\Contracts\Group $group
     */
    public function removeGroup($group)
    {
        $this->groups()->detach($this->getStoredGroup($group));
    }

    /**
     * Remove all current groups and set the given ones.
     *
     * @param array ...$groups
     *
     * @return $this
     */
    public function syncGroups(...$groups)
    {
        $this->groups()->detach();

        return $this->assignGroup($groups);
    }

    /**
     * Determine if the model has (one of) the given group(s).
     *
     * @param string|array|\Spatie\Permission\Contracts\Group|\Illuminate\Support\Collection $groups
     *
     * @return bool
     */
    public function hasGroup($groups): bool
    {
        if (is_string($groups))
        {
            return $this->groups->contains('name', $groups);
        }

        if ($groups instanceof Group)
        {
            return $this->groups->contains('id', $groups->id);
        }

        if (is_array($groups))
        {
            foreach ($groups as $group)
            {
                if ($this->hasGroup($group))
                {
                    return true;
                }
            }

            return false;
        }

        return $groups->intersect($this->groups)->isNotEmpty();
    }

    /**
     * Determine if the model has any of the given group(s).
     *
     * @param string|array|\Spatie\Permission\Contracts\Group|\Illuminate\Support\Collection $groups
     *
     * @return bool
     */
    public function hasAnyGroup($groups): bool
    {
        return $this->hasGroup($groups);
    }

    /**
     * Determine if the model has all of the given group(s).
     *
     * @param string|\Spatie\Permission\Contracts\Group|\Illuminate\Support\Collection $groups
     *
     * @return bool
     */
    public function hasAllGroups($groups): bool
    {
        if (is_string($groups))
        {
            return $this->groups->contains('name', $groups);
        }

        if ($groups instanceof Group)
        {
            return $this->groups->contains('id', $groups->id);
        }

        $groups = collect()->make($groups)->map(function ($group)
        {
            return $group instanceof Group ? $group->name : $group;
        });

        return $groups->intersect($this->groups->pluck('name')) == $groups;
    }

    protected function getStoredGroup($group): Group
    {
        if (is_string($group))
        {
            return app(Group::class)->findByName($group, $this->getDefaultGuardName());
        }

        return $group;
    }
}