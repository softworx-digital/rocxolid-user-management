<?php

namespace Softworx\RocXolid\UserManagement\Policies\Scopes;

use Illuminate\Contracts\Auth\Access\Authorizable;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;

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
     * @param \Illuminate\Contracts\Auth\Access\Authorizable $user
     * @param string $ability
     * @param string $model_class
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     */
    public function allows(Authorizable $user, string $ability, string $model_class, ?Crudable $model = null)
    {
        return true;
    }
}
