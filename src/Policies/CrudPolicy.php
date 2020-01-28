<?php

namespace Softworx\RocXolid\UserManagement\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;
// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid controller contracts
use Softworx\RocXolid\Http\Controllers\Contracts\Crudable as CrudableController;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Permission;

/**
 * Default policy for CRUDable controllers/models.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
class CrudPolicy
{
    use HandlesAuthorization;
    use Traits\AllowRootAccess;

    protected $request;

    protected $controller;

    public function __construct(CrudRequest $request)
    {
        $this->request = $request;
        $this->controller = $request->route()->getController();
    }

    /**
     * Determine whether the user can view any resources.
     *
     * @param \Illuminate\Contracts\Auth\Access\Authorizable $user
     *
     * @return bool
     */
    public function viewAny(Authorizable $user, ?string $model_class = null, ?string $forced_scope_type = null): bool
    {
        $model_class = $model_class ?? $this->controller->getModelClass();

        return $this->checkPermissions($user, 'viewAny', $model_class, null, $forced_scope_type);
    }

    /**
     * Determine whether the user can view the resource.
     *
     * @param \Illuminate\Contracts\Auth\Access\Authorizable $user
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @return bool
     */
    public function view(Authorizable $user, Crudable $model, ?string $attribute = null, ?string $forced_scope_type = null): bool
    {
        if ($attribute) {
            return $this->checkAttributePermissions($user, 'view', $model, $attribute);
        }

        return $this->checkPermissions($user, 'view', get_class($model), $model, $forced_scope_type);
    }

    /**
     * Determine whether the user can create resource.
     *
     * @param \Illuminate\Contracts\Auth\Access\Authorizable $user
     * @return bool
     */
    public function create(Authorizable $user, ?Crudable $model = null, ?string $attribute = null): bool
    {
dd($this->request->all());
        $model_class = $model_class ?? $this->controller->getModelClass();

        if ($attribute) {
            return $this->checkAttributePermissions($user, 'create', $model_class, $attribute);
        }

        return $this->checkPermissions($user, 'create', $model_class);
    }

    /**
     * Determine whether the user can update the resource.
     *
     * @param \Illuminate\Contracts\Auth\Access\Authorizable $user
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @return bool
     */
    public function update(Authorizable $user, Crudable $model, ?string $attribute = null): bool
    {
        if ($attribute) {
            return $this->checkAttributePermissions($user, 'update', $model, $attribute);
        }

        return $this->checkPermissions($user, 'update', get_class($model), $model);
    }

    /**
     * Determine whether the user can delete the resource.
     *
     * @param \Illuminate\Contracts\Auth\Access\Authorizable $user
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @return bool
     */
    public function delete(Authorizable $user, Crudable $model, ?string $attribute = null): bool
    {
        if ($attribute) {
            return $this->checkAttributePermissions($user, 'delete', $model, $attribute);
        }

        return $this->checkPermissions($user, 'delete', get_class($model), $model);
    }

    /**
     * Determine whether the user can assign the resource.
     *
     * @param \Illuminate\Contracts\Auth\Access\Authorizable $user
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @return bool
     */
    public function assign(Authorizable $user, Crudable $model, string $attribute): bool
    {
        return $this->checkAttributePermissions($user, 'assign', $model, $attribute);
    }

    /**
     * Actually check permissions.
     *
     * @param \Illuminate\Contracts\Auth\Access\Authorizable $user
     * @param string $ability
     * @param string $model_class
     * @return bool
     */
    protected function checkPermissions(Authorizable $user, string $ability, string $model_class, ?Crudable $model = null, ?string $forced_scope_type = null)
    {
        return collect([ 'permissions', 'rolePermissions' ])->reduce(function($allowed, $relation) use ($user, $ability, $model_class, $model, $forced_scope_type) {
            if ($permission = $this->getPermission($user, $relation, $ability, $model_class)) {
                return $this->allowPermission(
                    $permission,
                    $user,
                    $ability,
                    $model_class,
                    $model,
                    $forced_scope_type
                );
            }

            return $allowed || false;
        });
    }

    /**
     * Actually check permissions for relation.
     *
     * @param \Illuminate\Contracts\Auth\Access\Authorizable $user
     * @param string $ability
     * @param string $model_class
     * @return bool
     */
    protected function checkAttributePermissions(Authorizable $user, string $ability, Crudable $model, string $attribute)
    {
        return collect([ 'permissions', 'rolePermissions' ])->reduce(function($allowed, $relation) use ($user, $ability, $model, $attribute) {
            if ($permission = $this->getPermission($user, $relation, $ability, get_class($model), $attribute)) {
                return true;
            }

            return $allowed || false;
        });
    }

    protected function getPermission(
        Authorizable $user,
        string $relation,
        string $ability,
        string $model_class,
        ?string $attribute = null
    ) {
        return $user->$relation
            ->where('policy_ability', $ability)
            ->where('model_class', $model_class)
            ->where('attribute', $attribute)
            ->first();
    }

    protected function allowPermission(
        Permission $permission,
        Authorizable $user,
        string $ability,
        string $model_class,
        ?Crudable $model = null,
        ?string $forced_scope_type = null
    ) {
        $pivot = $permission->model_has_permissions ?? $permission->role_has_permissions;

        if (($pivot->directive === 'allow') && ($scope_type = $pivot->scope_type)) {
            // checking forced scope type assigned for this permission
            if ($forced_scope_type) {
                return ($forced_scope_type === $scope_type);
            }

            return app($scope_type)->allows($user, $ability, $model_class, $model);
        }

        return false;
    }
}
