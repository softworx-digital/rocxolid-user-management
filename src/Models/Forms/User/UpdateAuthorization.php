<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\User;

use PermissionLoader;
// rocXolid filters
use Softworx\RocXolid\Filters\Except;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// rocXolid form fields
use Softworx\RocXolid\Forms\Fields\Type\CollectionCheckbox;
// rocXolid user management form fields
use Softworx\RocXolid\UserManagement\Forms\Fields\Type\PermissionsAssignment;
// rocXolid user management models
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
        // updating self
        // @todo kinda "hotfixed"
        if (($user = auth('rocXolid')->user()) && $user->is($this->getModel())) {
            $except = $user->roles
                ->where('is_self_unassignable', 0)
                ->merge($user->getSelfNonAssignableRoles());

            $fields['roles']['options']['collection']['filters'] = [
                [
                    'class' => Except::class,
                    'data' => $except,
                ],
            ];
        }

        $fields['permissions']['options'] = [
            'collection' => PermissionLoader::get(),
            'label' => [
                'title' => 'permissions',
            ],
        ];

        unset($fields['permissions']); // @todo "hotfixed" for now

        return $fields;
    }
}
