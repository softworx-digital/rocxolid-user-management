<?php

namespace Softworx\RocXolid\UserManagement\Http\Controllers\Group;

use Softworx\RocXolid\UserManagement\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\UserManagement\Models\Group;
use Softworx\RocXolid\UserManagement\Repositories\Group\Repository;

class Controller extends AbstractCrudController
{
    protected static $model_class = Group::class;

    protected static $repository_class = Repository::class;
}