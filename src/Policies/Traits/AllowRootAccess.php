<?php

namespace Softworx\RocXolid\UserManagement\Policies\Traits;

use Illuminate\Contracts\Auth\Access\Authorizable;

trait AllowRootAccess
{
    /**
     * Allow root access for all abilities.
     *
     * @param \Illuminate\Contracts\Auth\Access\Authorizable $user
     * @param string $ability
     * @return bool|void
     */
    public function checkAllowRootAccess(Authorizable $user, string $ability): ?bool
    {
        if (!config('rocXolid.admin.auth.check_permissions_root', false) && $user->isRoot()) {
            return true;
        }

        return null;
    }
}