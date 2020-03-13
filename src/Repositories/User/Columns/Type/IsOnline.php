<?php

namespace Softworx\RocXolid\UserManagement\Repositories\User\Columns\Type;

use Softworx\RocXolid\Repositories\Columns\AbstractColumn;

class IsOnline extends AbstractColumn
{
    protected $default_options = [
        'view-package' => 'rocXolid:user-management',
        'type-template' => 'is-online',
        /*
        // field wrapper
        'wrapper' => false,
        // column HTML attributes
        'attributes' => [
            'class' => 'form-control'
        ],
        */
    ];
}
