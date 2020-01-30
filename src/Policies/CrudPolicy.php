<?php

namespace Softworx\RocXolid\UserManagement\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid user management contracts
use Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization;

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
     * @param \Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization $user
     * @param string $ability
     * @return bool|null
     */
    public function before(HasAuthorization $user, string $ability): ?bool
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
     * @param \Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization $user
     * @param string $model_class
     * @param string $forced_scope_type
     * @return bool
     */
    public function viewAny(HasAuthorization $user, ?string $model_class = null, ?string $forced_scope_type = null): bool
    {
        $model_class = $model_class ?? $this->controller->getModelClass();

        return $this->checkPermissions($user, 'viewAny', $model_class, null, $forced_scope_type);
    }

    /**
     * Determine whether the user can view the resource.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization $user
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param string $forced_scope_type
     * @return bool
     */
    public function view(HasAuthorization $user, Crudable $model, ?string $attribute = null, ?string $forced_scope_type = null): bool
    {
        if ($attribute) {
            return $this->checkAttributePermissions($user, 'view', $model, $attribute);
        }

        return $this->checkPermissions($user, 'view', get_class($model), $model, $forced_scope_type);
    }

    /**
     * Determine whether the user can create resource.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization $user
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param string $attribute
     * @return bool
     */
    public function create(HasAuthorization $user, ?Crudable $model = null, ?string $attribute = null): bool
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
     * @param \Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization $user
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param string $attribute
     * @return bool
     */
    public function update(HasAuthorization $user, Crudable $model, ?string $attribute = null): bool
    {
        if ($attribute) {
            return $this->checkAttributePermissions($user, 'update', $model, $attribute);
        }

        return $this->checkPermissions($user, 'update', get_class($model), $model);
    }

    /**
     * Determine whether the user can delete the resource.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization $user
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param string $attribute
     * @return bool
     */
    public function delete(HasAuthorization $user, Crudable $model, ?string $attribute = null): bool
    {
        if ($attribute) {
            return $this->checkAttributePermissions($user, 'delete', $model, $attribute);
        }

        return $this->checkPermissions($user, 'delete', get_class($model), $model);
    }

    /**
     * Determine whether the user can assign the resource.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization $user
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param string $attribute
     * @return bool
     */
    public function assign(HasAuthorization $user, Crudable $model, string $attribute): bool
    {
        return $this->checkAttributePermissions($user, 'assign', $model, $attribute);
    }

    /**
     * Actually check permissions for main model.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization $user
     * @param string $ability
     * @param string $model_class
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param string $forced_scope_type
     * @return bool
     */
    protected function checkPermissions(HasAuthorization $user, string $ability, string $model_class, ?Crudable $model = null, ?string $forced_scope_type = null): bool
    {
        return ($permission = $user->getPermissionFor($ability, $model_class))
            && (!$model || $user->allowPermission($permission, $ability, $model, $forced_scope_type));
    }

    /**
     * Actually check permissions for model relation.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization $user
     * @param string $ability
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param string $attribute
     * @return bool
     */
    protected function checkAttributePermissions(HasAuthorization $user, string $ability, Crudable $model, string $attribute): bool
    {
        return filled($user->getPermissionFor($ability, get_class($model), $attribute));
    }
}
