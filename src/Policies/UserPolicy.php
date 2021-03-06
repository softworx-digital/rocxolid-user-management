<?php

namespace Softworx\RocXolid\UserManagement\Policies;

// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid user management contracts
use Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization;
// rocXolid user management policies
use Softworx\RocXolid\UserManagement\Policies\CrudPolicy;

/**
 * User controller/model policy.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
class UserPolicy extends CrudPolicy
{
    /**
     * {@inheritDoc}
     */
    public function before(HasAuthorization $user, string $ability): ?bool
    {
        switch ($ability) {
            case 'delete':
                return null;
        }

        return parent::before($user, $ability);
    }

    /**
     * {@inheritDoc}
     */
    public function view(HasAuthorization $user, Crudable $model, ?string $attribute = null, ?string $forced_scope_type = null): bool
    {
        if ($model->isRoot() && !$user->isRoot()) {
            return false;
        }

        return parent::view($user, $model, $attribute, $forced_scope_type);
    }

    /**
     * {@inheritDoc}
     */
    public function update(HasAuthorization $user, Crudable $model, ?string $attribute = null): bool
    {
        if ($model->isRoot() && !$user->isRoot()) {
            return false;
        }

        return parent::update($user, $model, $attribute);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(HasAuthorization $user, Crudable $model, ?string $attribute = null): bool
    {
        if (!config('rocXolid.admin.auth.check_permissions_root', false) && $user->isRoot()) {
            return !is_null($attribute) || !$user->is($model);
        }

        // return parent::delete($user, $model) && (!$user->isAdmin() || !$user->is($model)); // allow self deletion
        // return parent::delete($user, $model) && !$user->is($model);
        return parent::delete($user, $model) // has permission to delete users in general
            && !$user->is($model) // @todo hotfixed - user cannot delete self
            && !$model->isAdmin(); // @todo hotfixed - user cannot delete other admins
    }

    /**
     * {@inheritDoc}
     */
    public function assign(HasAuthorization $user, Crudable $model, string $attribute): bool
    {
        return $this->checkAttributePermissions($user, 'assign', $model, $attribute);
    }
}
