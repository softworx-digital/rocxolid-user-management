<?php

namespace Softworx\RocXolid\UserManagement\Policies;

// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid user management contracts
use Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization;

/**
 * User policy for CRUDable controllers/models.
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
    public function delete(HasAuthorization $user, Crudable $model, ?string $attribute = null): bool
    {
        if (!config('rocXolid.admin.auth.check_permissions_root', false) && $user->isRoot()) {
            return !$user->is($model);
        }

        return parent::delete($user, $model) && (!$user->isAdmin() || !$user->is($model));
    }

    /**
     * {@inheritDoc}
     */
    public function assign(HasAuthorization $user, Crudable $model, string $attribute): bool
    {
        return $this->checkAttributePermissions($user, 'assign', $model, $attribute);
    }
}
