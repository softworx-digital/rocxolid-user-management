<?php

namespace Softworx\RocXolid\UserManagement\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;
// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;

class PermissionPolicy extends CrudPolicy
{
    /**
     * Determine whether the user do permission synchronization.
     *
     * @param \Illuminate\Contracts\Auth\Access\Authorizable $user
     * @return bool
     */
    public function synchronize(Authorizable $user): bool
    {
        dd(__METHOD__);
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(Authorizable $user, Crudable $model, ?string $attribute = null): bool
    {
        dd(__METHOD__);
        return true;
    }
}
