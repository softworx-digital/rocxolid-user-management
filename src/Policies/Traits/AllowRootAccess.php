<?php

namespace Softworx\RocXolid\UserManagement\Policies\Traits;

// rocXolid user management contracts
use Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization;

/**
 * Trait to allow access to all abilities for a root user.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
trait AllowRootAccess
{
    /**
     * Allow root access for all abilities.
     *
     * @param \Illuminate\Contracts\Auth\Access\Authorizable $user
     * @param string $ability
     * @return bool|void
     */
    public function checkAllowRootAccess(HasAuthorization $user, string $ability): ?bool
    {
        if (!config('rocXolid.admin.auth.check_permissions_root', false) && $user->isRoot()) {
            return true;
        }

        return null;
    }
}
