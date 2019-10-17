<?php

namespace Softworx\RocXolid\UserManagement\Http\Controllers;

use Softworx\RocXolid\Http\Controllers\AbstractCrudController as RocXolidAbstractCrudController;
use Softworx\RocXolid\UserManagement\Components\Dashboard\Crud as CrudDashboard;

abstract class AbstractCrudController extends RocXolidAbstractCrudController
{
    protected static $dashboard_class = CrudDashboard::class;
}