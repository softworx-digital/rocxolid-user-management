<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\User;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type\Email;
use Softworx\RocXolid\Forms\Fields\Type\Hidden;
use Softworx\RocXolid\Forms\Fields\Type\Password;
use Softworx\RocXolid\Forms\Fields\Type\ButtonSubmit;

/**
 *
 */
class ResetPassword extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'passwordReset',
        'class' => 'form-horizontal form-label-left',
        'show-back-button' => false,
    ];

    protected $fields = [
        'token' => [
            'type' => Hidden::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
        'email' => [
            'type' => Email::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                        'email',
                        'exists:users,email',
                    ],
                ],
                'attributes' => [
                    'placeholder' => 'email',
                ],
            ],
        ],
        'password' => [
            'type' => Password::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                        'max:255',
                        'min:6',
                        //'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/',
                        'confirmed',
                    ],
                ],
                'attributes' => [
                    'placeholder' => 'password',
                ],
            ],
        ],
        'password_confirmation' => [
            'type' => Password::class,
            'options' => [
                'attributes' => [
                    'placeholder' => 'password_confirmation',
                ],
            ],
        ],
    ];

    protected $buttons = [
        'submit' => [
            'type' => ButtonSubmit::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'submit',
                ],
                'attributes' => [
                    'class' => 'btn btn-primary',
                ],
            ],
        ],
    ];
}
