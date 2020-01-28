<?php

namespace Softworx\RocXolid\UserManagement\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasManyThrough;
// third-party
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Role;
use Softworx\RocXolid\UserManagement\Models\Permission;
// rocXolid user management model pivots
use Softworx\RocXolid\UserManagement\Models\Pivots\RolePermission;

/**
 * Trait to retrieve role permissions for a model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
trait HasRolePermissions
{
    use HasRelationships;

    /**
     * {@inheritDoc}
     */
    public function rolePermissions(): HasManyDeep
    {
        return $this
            ->hasManyDeepFromRelations($this->roles(), $this->roles()->make()->permissions())
            ->withPivot('role_has_permissions', [
                'directive',
                'scope_type',
            ])->withoutGlobalScopes();
    }
}
