<?php

namespace Softworx\RocXolid\UserManagement\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid model traits
use Softworx\RocXolid\Models\Traits\Crudable;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Permission;
// rocXolid user management model pivots
use Softworx\RocXolid\UserManagement\Models\Pivots\RolePermission;

/**
 * User Role model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
class Role extends AbstractCrudModel
{
    protected static $title_column = 'name';

    protected $fillable = [
        'name',
        //'guard',
    ];

    protected $relationships = [
        'permissions',
    ];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions')
            ->using(RolePermission::class)
            ->withPivot([
                'scope_type',
            ]);
    }
}
