<?php

namespace Softworx\RocXolid\UserManagement\Http\Controllers\Permission;

use Softworx\RocXolid\UserManagement\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\UserManagement\Models\Permission;
use Softworx\RocXolid\UserManagement\Repositories\Permission\Repository;

class Controller extends AbstractCrudController
{
    protected static $model_class = Permission::class;

    protected static $repository_class = Repository::class;
}