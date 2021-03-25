<?php

namespace Softworx\RocXolid\UserManagement\Models\Tables\User\Columns\Type;

use Softworx\RocXolid\Tables\Columns\AbstractColumn;

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
