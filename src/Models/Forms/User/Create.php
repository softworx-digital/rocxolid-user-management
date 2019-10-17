<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\User;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type\Input;
use Softworx\RocXolid\Forms\Fields\Type\Email;
use Softworx\RocXolid\Forms\Fields\Type\Password;
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelect;
use Softworx\RocXolid\Forms\Fields\Type\CollectionCheckbox;
use Softworx\RocXolid\Common\Models\Language;
use Softworx\RocXolid\UserManagement\Models\Group;
use Softworx\RocXolid\UserManagement\Models\Role;

class Create extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
    ];

    protected $fields = [
        'name' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'name',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'max:255',
                    ],
                ],
            ],
        ],/*
        'birthnumber' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'birthnumber',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'max:255',
                    ],
                ],
            ],
        ],*/
        'email' => [
            'type' => Email::class,
            'options' => [
                'label' => [
                    'title' => 'email',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'email',
                        'unique:users,email',
                    ],
                ],
            ],
        ],
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
        'language_id' => [
            'type' => CollectionSelect::class,
            'options' => [
                'label' => [
                    'title' => 'language',
                ],
            ],
        ],/*
        'groups' => [
            'type' => CollectionCheckbox::class,
            'options' => [
                'label' => [
                    'title' => 'groups',
                ],
                'collection' => [
                    'model' => Group::class,
                    'column' => 'name',
                ],
            ],
        ],
        'roles' => [
            'type' => CollectionCheckbox::class,
            'options' => [
                'label' => [
                    'title' => 'roles',
                ],
                'collection' => [
                    'model' => Role::class,
                    'column' => 'name',
                ],
            ],
        ],*/
    ];

    protected function adjustFieldsDefinition($fields)
    {
        $fields['language_id']['options']['collection'] = Language::where('is_admin_available', 1)->pluck('name', 'id');

        return $fields;
    }
}