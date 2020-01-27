<?php

namespace Softworx\RocXolid\UserManagement\Policies;

use Debugbar;
use Illuminate\Auth\Access\HandlesAuthorization;
// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\User;

class PermissionPolicy extends CrudPolicy
{
    /**
     * Determine whether the user do permission synchronization.
     *
     * @param \App\User $user
     * @return bool
     */
    public function synchronize(User $user): bool
    {
        dd(__METHOD__);
        return true;
    }

    /**
     * Determine whether the user can delete the resource.
     *
     * @param \App\User $user
     * @param \App\WorkLog $model
     * @return bool
     */
    public function delete(User $user, Crudable $model): bool
    {
        dd(__METHOD__);
        return true;
    }
}
