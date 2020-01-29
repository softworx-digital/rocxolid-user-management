<?php

namespace Softworx\RocXolid\UserManagement\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;
// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
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
    use Traits\AllowRelation;

    /**
     * @var \Softworx\RocXolid\Http\Requests\CrudRequest
     */
    protected $request;

    /**
     * @var \Softworx\RocXolid\Http\Controllers\Contracts\Crudable
     */
    protected $controller;

    /**
     * Constructor.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @return \Softworx\RocXolid\UserManagement\Policies\CrudPolicy
     */
    public function __construct(CrudRequest $request)
    {
        $this->request = $request;
        $this->controller = $request->route()->getController();
    }

    /**
     * Do some checking before passing the logic to the main policy methods.
     *
     * @param \Illuminate\Contracts\Auth\Access\Authorizable $user
     * @param string $ability
     * @return bool|null
     */
    public function before(Authorizable $user, string $ability): ?bool
    {
        if (!is_null($allow = $this->checkAllowRootAccess($user, $ability))) {
            return $allow;
        }

        if (!is_null($allow = $this->checkAllowRelation($user, $ability))) {
            return $allow;
        }

        return null;
    }

    /**
     * Determine whether the user can view any resources.
     *
     * @param \Illuminate\Contracts\Auth\Access\Authorizable $user
     * @param string $model_class
     * @param string $forced_scope_type
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
     * @param string $forced_scope_type
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
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param string $attribute
     * @return bool
     */
    public function create(Authorizable $user, ?Crudable $model = null, ?string $attribute = null): bool
    {
        if ($model && $attribute) {
            return $this->checkAttributePermissions($user, 'create', $model, $attribute);
        }

        $model_class = $model_class ?? $this->controller->getModelClass();

        return $this->checkPermissions($user, 'create', $model_class);
    }

    /**
     * Determine whether the user can update the resource.
     *
     * @param \Illuminate\Contracts\Auth\Access\Authorizable $user
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param string $attribute
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
     * @param string $attribute
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
     * @param string $attribute
     * @return bool
     */
    public function assign(Authorizable $user, Crudable $model, string $attribute): bool
    {
        return $this->checkAttributePermissions($user, 'assign', $model, $attribute);
    }

    /**
     * Actually check permissions for main model.
     *
     * @param \Illuminate\Contracts\Auth\Access\Authorizable $user
     * @param string $ability
     * @param string $model_class
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param string $forced_scope_type
     * @return bool
     */
    protected function checkPermissions(Authorizable $user, string $ability, string $model_class, ?Crudable $model = null, ?string $forced_scope_type = null): bool
    {
        // iterate through user's direct permissions first, then througn permissions granted by assigned roles
        return collect([ 'permissions', 'rolePermissions' ])->reduce(function($allowed, $relation) use ($user, $ability, $model_class, $model, $forced_scope_type) {
            if ($permission = $this->getPermission($user, $relation, $ability, $model_class)) {
                // having the permission, further check if the permission is allowed by its scope
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
     * Actually check permissions for model relation.
     *
     * @param \Illuminate\Contracts\Auth\Access\Authorizable $user
     * @param string $ability
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param string $attribute
     * @return bool
     */
    protected function checkAttributePermissions(Authorizable $user, string $ability, Crudable $model, string $attribute): bool
    {
        // iterate through user's direct permissions first, then througn permissions granted by assigned roles
        return collect([ 'permissions', 'rolePermissions' ])->reduce(function($allowed, $relation) use ($user, $ability, $model, $attribute) {
            if ($permission = $this->getPermission($user, $relation, $ability, get_class($model), $attribute)) {
                // attribute permissions don't have scope
                return true;
            }

            return $allowed || false;
        });
    }

    /**
     * Get permission based on constraints.
     *
     * @param \Illuminate\Contracts\Auth\Access\Authorizable $user
     * @param string $relation
     * @param string $ability
     * @param string $model_class
     * @param string $attribute
     * @return \Softworx\RocXolid\UserManagement\Models\Permission|null
     */
    protected function getPermission(
        Authorizable $user,
        string $relation,
        string $ability,
        string $model_class,
        ?string $attribute = null
    ): ?Permission {
        return $user->$relation
            ->where('policy_ability', $ability)
            ->where('model_class', $model_class)
            ->where('attribute', $attribute)
            ->first();
    }

    /**
     * Check if permission is allowed in permission's scope.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Permission $permission
     * @param \Illuminate\Contracts\Auth\Access\Authorizable $user
     * @param string $ability
     * @param string $model_class
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param string $forced_scope_type
     * @return bool
     */
    protected function allowPermission(
        Permission $permission,
        Authorizable $user,
        string $ability,
        string $model_class,
        ?Crudable $model = null,
        ?string $forced_scope_type = null
    ): bool {
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
