<?php

namespace Softworx\RocXolid\UserManagement\Components\ModelViewers;

// rocXolid components
use Softworx\RocXolid\Components\ModelViewers\TabbedCrudModelViewer as RocXolidTabbedCrudModelViewer;

/**
 * Tabbed user management model viewer component.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
abstract class AbstractTabbedCrudModelViewer extends RocXolidTabbedCrudModelViewer
{
    protected $view_package = 'rocXolid:user-management';
}
