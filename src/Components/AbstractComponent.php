<?php

namespace Softworx\RocXolid\UserManagement\Components;

use Softworx\RocXolid\Components\AbstractComponent as RocXolidAbstractComponent;

abstract class AbstractComponent extends RocXolidAbstractComponent
{
    protected $view_package = 'rocXolid:user-management';

    protected $view_directory = '';

    protected $translation_package = 'rocXolid:user-management';
}