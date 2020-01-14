<?php

namespace Softworx\RocXolid\UserManagement\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Softworx\RocXolid\Models\AbstractCrudModel;
use Softworx\RocXolid\Models\Traits\Crudable;
use Softworx\RocXolid\UserManagement\Models\Permission;

// @todo - odrezat spatie
class Role extends AbstractCrudModel
{
    protected static $title_column = 'name';

    protected $fillable = [
        'name',
        //'guard_name',
    ];

    protected $relationships = [
        'permissions',
    ];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }
}
