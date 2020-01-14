<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\User;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type\Password;

class UpdateAuthentication extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
        'section' => 'authentication-data',
    ];

    protected $fields = [
        'password' => [
            'type' => Password::class,
            'options' => [
                'label' => [
                    'title' => 'password'
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'max:255',
                        'min:6',
                        //'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/',
                        'confirmed',
                    ],
                ],
            ],
        ],
        'password_confirmation' => [
            'type' => Password::class,
            'options' => [
                'label' => [
                    'title' => 'password_confirmation'
                ],
            ],
        ],
    ];
}
