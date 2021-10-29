<?php

namespace Softworx\RocXolid\UserManagement\Components\ModelViewers;

// rocXolid components
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as RocXolidCrudModelViewer;

/**
 * Basic user management model viewer component.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
abstract class AbstractCrudModelViewer extends RocXolidCrudModelViewer
{
    protected $view_package = 'rocXolid:user-management';
}
