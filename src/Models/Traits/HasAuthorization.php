<?php

namespace Softworx\RocXolid\UserManagement\Models\Traits;

use Illuminate\Support\Collection;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid user management model traits
use Softworx\RocXolid\UserManagement\Models\Traits\HasRoles;
use Softworx\RocXolid\UserManagement\Models\Traits\HasPermissions;
use Softworx\RocXolid\UserManagement\Models\Traits\HasRolePermissions;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Permission;

/**
 * Trait to retrieve permission for a model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
trait HasAuthorization
{
    use HasRoles;
    use HasPermissions;
    use HasRolePermissions;

    /**
     * {@inheritDoc}
     */
    public function getPermissionFor(
        string $ability,
        string $model_class,
        ?string $attribute = null
    ): ?Permission {
        return $this->permissionQuery($this->permissions, $ability, $model_class, $attribute)->first()
            ?? $this->permissionQuery($this->rolePermissions, $ability, $model_class, $attribute)->first()
            ?? null;
    }

    /**
     * {@inheritDoc}
     */
    public function allowPermission(
        Permission $permission,
        string $ability,
        ?Crudable $model = null,
        ?string $forced_scope_type = null
    ): bool {
        $pivot = $permission->model_has_permissions ?? $permission->role_has_permissions;

        if (($pivot->directive === 'allow') && ($scope_type = $pivot->scope_type)) {
            // checking forced scope type assigned for this permission
            if ($forced_scope_type) {
                return ($forced_scope_type === $scope_type);
            }

            return app($scope_type)->allows($this, $ability, $model);
        }

        return false;
    }

    /**
     * Query given collection for ability, model class and attribute.
     *
     * @param string $ability
     * @param string $model_class
     * @param string $attribute
     * @return \Illuminate\Support\Collection
     */
    private function permissionQuery(
        Collection $collection,
        string $ability,
        string $model_class,
        ?string $attribute = null
    ): Collection {
        return $collection
            ->where('policy_ability', $ability)
            ->where('model_class', $model_class)
            ->where('attribute', $attribute);
    }
}
