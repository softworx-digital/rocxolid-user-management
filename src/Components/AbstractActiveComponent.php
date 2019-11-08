<?php

namespace Softworx\RocXolid\UserManagement\Components;

use Softworx\RocXolid\Components\AbstractActiveComponent as RocXolidAbstractActiveComponent;

abstract class AbstractActiveComponent extends RocXolidAbstractActiveComponent
{
    // @todo: cleanup, fallback probably not needed
    protected $view_package = [
        'rocXolid:user-management',
        'rocXolid', // fallback
    ];

    protected $view_directory = '';

    protected $translation_package = 'rocXolid:user-management';
}