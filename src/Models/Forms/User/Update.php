<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\User;

use Auth;
use Illuminate\Validation\Rule;
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type\Input;
use Softworx\RocXolid\Forms\Fields\Type\Email;
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelect;
use Softworx\RocXolid\Forms\Fields\Type\CollectionCheckbox;
use Softworx\RocXolid\Common\Models\Language;
use Softworx\RocXolid\UserManagement\Models\Group;
use Softworx\RocXolid\UserManagement\Models\Role;
use Softworx\RocXolid\UserManagement\Models\Permission;

class Update extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
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
        ],
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
                    ],
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
        ],*/
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
        ],/*
        'permissions' => [
            'type' => CollectionCheckbox::class,
            'options' => [
                'label' => [
                    'title' => 'extra_permissions',
                ],
                'collection' => [
                    'model' => Permission::class,
                    'column' => 'name',
                    'method' => 'getTitle',
                ],
            ],
        ],*/
    ];

    protected function adjustFieldsDefinition($fields)
    {
        // @todo: hotfix
        return [];

        $rule = Rule::unique('users', 'email')
            ->ignore($this->getModel()->getKey());

        $fields = array_merge_recursive($fields, [
            'email' => [
                'options' => [
                    'validation' => [
                        'rules' => [
                            $rule
                        ],
                    ],
                ],
            ],
        ]);

        if ($user = Auth::guard('rocXolid')->user()) {
            if ($user->is($this->getModel())) {
                unset($fields['roles']);
            }
        }

        return $fields;
    }
}
