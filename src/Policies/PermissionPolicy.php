<?php

namespace Softworx\RocXolid\UserManagement\Policies;

// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid user management contracts
use Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;

class PermissionPolicy extends CrudPolicy
{
    /**
     * Determine whether the user do permission synchronization.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization $user
     * @return bool
     */
    public function synchronize(HasAuthorization $user): bool
    {
        dd(__METHOD__);
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(HasAuthorization $user, Crudable $model, ?string $attribute = null): bool
    {
        dd(__METHOD__);
        return true;
    }
}
