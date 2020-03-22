<?php

namespace Softworx\RocXolid\UserManagement\Models\Scopes;

use Auth;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProtectingRoot implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where($model->getQualifiedKeyName(), '!=', $model::ROOT_ID);
    }
}
