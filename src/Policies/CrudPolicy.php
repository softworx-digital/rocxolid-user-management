<?php

namespace Softworx\RocXolid\UserManagement\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\User;

class CrudPolicy
{
    use HandlesAuthorization;

    protected $request;

    public function __construct(CrudRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Determine whether the user can view any resources.
     *
     * @param \App\User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        // dump(__METHOD__);
        // dump($user);
        return true;
    }

    /**
     * Determine whether the user can view the resource.
     *
     * @param \App\User $user
     * @param \App\WorkLog $model
     * @return bool
     */
    public function view(User $user, Crudable $model): bool
    {
        // dump(__METHOD__);
        // dump($this->request->route()->getController());
        // dd($model);
        return true;
    }

    /**
     * Determine whether the user can create resource.
     *
     * @param \App\User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        // dump(__METHOD__);
        return true;
    }

    /**
     * Determine whether the user can update the resource.
     *
     * @param \App\User $user
     * @param \App\WorkLog $model
     * @return bool
     */
    public function update(User $user, Crudable $model): bool
    {
        // dump(__METHOD__);
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
        // dump(__METHOD__);
        return true;
    }
}
