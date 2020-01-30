<?php

namespace Softworx\RocXolid\UserManagement\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Role;

/**
 *
 */
class ExceptRole
{
    public function apply(Builder $query, Model $queried_model, Role $role)
    {
        return $query->where(sprintf('%s.%s', $queried_model->getTable(), $queried_model->getKeyName()), '<>', $role->getKey());
    }
}
