<?php

namespace Softworx\RocXolid\UserManagement\Http\Controllers;

use Softworx\RocXolid\Http\Controllers\AbstractCrudController as RocXolidAbstractCrudController;
// admin components
use Softworx\RocXolid\Admin\Components\Dashboard\Crud as CrudDashboard;

abstract class AbstractCrudController extends RocXolidAbstractCrudController
{
    protected static $dashboard_class = CrudDashboard::class;
}