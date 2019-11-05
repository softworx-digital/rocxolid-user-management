<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\User;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type\CollectionCheckbox;
use Softworx\RocXolid\UserManagement\Models\Group;
use Softworx\RocXolid\UserManagement\Models\Role;
use Softworx\RocXolid\UserManagement\Models\Permission;

class UpdateAuthorization extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
        'section' => 'authorization-data',
    ];

    protected $fields = [
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
        ],
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
        ],
    ];
}