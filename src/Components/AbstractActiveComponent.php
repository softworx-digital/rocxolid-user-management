<?php

namespace Softworx\RocXolid\UserManagement\Components;

use Softworx\RocXolid\Components\AbstractActiveComponent as RocXolidAbstractActiveComponent;

abstract class AbstractActiveComponent extends RocXolidAbstractActiveComponent
{
    protected $view_package = 'rocXolid:user-management';

    protected $view_directory = '';

    protected $translation_package = 'rocXolid:user-management';
}
