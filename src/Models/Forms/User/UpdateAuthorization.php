<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\User;

use PermissionLoader;
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type\CollectionCheckbox;
use Softworx\RocXolid\UserManagement\Forms\Fields\Type\PermissionsAssignment;
use Softworx\RocXolid\UserManagement\Models\Group;
use Softworx\RocXolid\UserManagement\Models\Role;
use Softworx\RocXolid\UserManagement\Models\Permission;
// filters
use Softworx\RocXolid\UserManagement\Filters\ExceptRole;

class UpdateAuthorization extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
        'section' => 'authorization-data',
    ];

    protected $fields = [/*
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
        ],
        'permissions' => [
            'type' => PermissionsAssignment::class,
            'options' => [
                'label' => [
                    'title' => 'extra_permissions',
                ],
            ],
        ],
    ];

    protected function adjustFieldsDefinition($fields)
    {
        if (($user = auth('rocXolid')->user()) && $user->is($this->getModel())) {
            $fields['roles']['options']['collection']['filters'] = [
                [
                    'class' => ExceptRole::class,
                    'data' => Role::findOrFail(config('rocXolid.admin.auth.admin_role_id')), // @todo: hotfixed
                ],
            ];
        }

        $fields['permissions']['options'] = [
            'collection' => PermissionLoader::get(),
            'label' => [
                'title' => 'permissions',
            ],
        ];

        unset($fields['permissions']); // @todo: hotfix for now

        return $fields;
    }
}
