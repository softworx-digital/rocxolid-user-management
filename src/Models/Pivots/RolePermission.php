<?php

namespace Softworx\RocXolid\UserManagement\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RolePermission extends Pivot
{
    protected $table = 'role_has_permissions';

    protected $fillable = [
        'scope_type',
    ];
}