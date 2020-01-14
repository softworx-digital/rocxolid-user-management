<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\User;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type\Email;
use Softworx\RocXolid\Forms\Fields\Type\ButtonSubmit;

/**
 *
 */
class ForgotPassword extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'forgotPassword',
        'class' => 'form-horizontal form-label-left',
        'show-back-button' => false,
    ];

    protected $fields = [
        'email' => [
            'type' => Email::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'email',
                        'exists:users,email',
                    ],
                ],
                'attributes' => [
                    'placeholder' => 'email',
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