<?php

namespace Softworx\RocXolid\UserManagement\Policies\Scopes;

// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid user management contracts
use Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization;

/**
 * All resource permission scope.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Admin
 * @version 1.0.0
 */
class All
{
    public $icon = 'globe';

    /**
     * Check if permission with this scope allows ability for user.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization $user
     * @param string $ability
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     */
    public function allows(HasAuthorization $user, string $ability, ?Crudable $model = null): bool
    {
        return true;
    }
}
