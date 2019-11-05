<?php

namespace Softworx\RocXolid\UserManagement\Components\ModelViewers;

use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as RocXolidCrudModelViewer;

/**
 *
 */
class CrudModelViewer extends RocXolidCrudModelViewer
{
    protected $view_package = 'rocXolid:user-management';

    protected $view_directory = '';

    protected $translation_package = 'rocXolid:user-management';
}
