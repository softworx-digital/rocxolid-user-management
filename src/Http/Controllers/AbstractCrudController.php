<?php

namespace Softworx\RocXolid\UserManagement\Http\Controllers;

// rocXolid controllers
use Softworx\RocXolid\Http\Controllers\AbstractCrudController as RocXolidAbstractCrudController;
// rocXolid admin components
use Softworx\RocXolid\Admin\Components\Dashboard\Crud as CrudDashboard;

/**
 * rocXolid User Management CRUD controller.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
abstract class AbstractCrudController extends RocXolidAbstractCrudController
{
    protected static $dashboard_type = CrudDashboard::class;

    protected $translation_package = 'rocXolid-user-management';
}
