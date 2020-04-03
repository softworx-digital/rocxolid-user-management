<?php

namespace Softworx\RocXolid\UserManagement\Http\Controllers\Role;

use Softworx\RocXolid\UserManagement\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\UserManagement\Models\Role;
use Softworx\RocXolid\UserManagement\Repositories\Role\Repository;

class Controller extends AbstractCrudController
{


    protected static $repository_class = Repository::class;
}
