<?php

namespace Softworx\RocXolid\UserManagement\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid traits
use Softworx\RocXolid\Traits\Loggable;
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
    use Loggable;
    use HandlesAuthorization;
    use Traits\AllowRootAccess;
    use Traits\AllowRelation;

    /**
     * @var bool Switch to turn debugging on / off.
     * @todo: config / env
     */
    protected $debug = false;

    /**
     * @var bool Switch to turn logging on / off.
     * @todo: config / env
     */
    protected $log = false;

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
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request Incoming request.
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
        if (!is_null($allowed = $this->checkAllowRootAccess($user, $ability))) {
$this->debug(sprintf('Before 1 ability: %s', $ability), $allowed);
            return $allowed;
        }

        // the purpose of this is to handle authorization of model attributes when doing requests
        // the problem is that authorizeResource() doesn't take attribute into consideration
        if (!is_null($allowed = $this->checkAllowRelation($user, $ability))) {
$this->debug(sprintf('Before 2 ability: %s', $ability), $allowed);
            return $allowed;
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
    public function viewAny(HasAuthorization $user, ?string $model_class = null): bool
    {
        $model_class = $model_class ?? $this->controller->getModelType();

        return $this->checkPermissions($user, 'viewAny', $model_class);
    }

    /**
     * Determine whether the user can view all resources.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization $user
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param string $forced_scope_type
     * @return bool
     */
    public function viewAnyAll(HasAuthorization $user, Crudable $model): bool
    {
        return $this->checkPermissions($user, 'viewAny', get_class($model), $model, 'policy.scope.all');
    }

    /**
     * Shorthand for view any.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization $user
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param string $forced_scope_type
     * @return bool
     */
    public function backAny(HasAuthorization $user, Crudable $model): bool
    {
        return $this->checkPermissions($user, 'viewAny', get_class($model));
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

        $model_class = $model ? get_class($model) : $this->controller->getModelType();

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
        if ($model) {
            $message = sprintf('Checking permission for user [%s], ability [%s], model [%s]:[%s], scope type [%s]', $user->getKey(), $ability, get_class($model), $model->getKey(), $forced_scope_type);
        } else {
            $message = sprintf('Checking permission for user [%s], ability [%s], model [%s], scope type [%s]', $user->getKey(), $ability, $model_class, $forced_scope_type);
        }

        $allowed = ($permission = $user->getPermissionFor($ability, $model_class))
                && (!$model || $user->allowPermission($permission, $ability, $model, $forced_scope_type));

        $this->debug($message, $allowed);

        return $allowed;
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
        $message = sprintf('Checking permission for user [%s], ability [%s], model [%s]:[%s], attribute [%s]', $user->getKey(), $ability, get_class($model), $model->getKey(), $attribute);

        $allowed = filled($user->getPermissionFor($ability, get_class($model), $attribute));

        $this->debug($message, $allowed);

        return $allowed;
    }

    /**
     * Debug logging.
     *
     * @param string $message
     * @param string $allowed
     * @return \Softworx\RocXolid\UserManagement\Policies\CrudPolicy
     */
    private function debug(string $message, string $allowed, $depth = 20): CrudPolicy
    {
        if ($this->debug) {
            debug(sprintf('%s %s', ($allowed ? '✅' : '❌'), $message));

            if (!$allowed) {
                for ($i = $depth; $i >= 0; $i--) {
                    debug(sprintf('%s::%s', debug_backtrace()[$i]['class'] ?? debug_backtrace()[$i]['file'], debug_backtrace()[$i]['function']));
                }
            }
        }

        $this->log(sprintf('[%s] %s: %s', get_class($this), $message, ($allowed ? '✅' : '❌')));

        return $this;
    }
}
