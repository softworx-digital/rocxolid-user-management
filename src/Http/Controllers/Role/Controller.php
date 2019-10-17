<?php

namespace Softworx\RocXolid\UserManagement\Http\Controllers\Role;

use Softworx\RocXolid\UserManagement\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\UserManagement\Models\Role;
use Softworx\RocXolid\UserManagement\Repositories\Role\Repository;

class Controller extends AbstractCrudController
{
    protected static $model_class = Role::class;

    protected static $repository_class = Repository::class;
}