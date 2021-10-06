<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\User;

use PermissionLoader;
// rocXolid filters
use Softworx\RocXolid\Filters;
// rocXolid forms & related
use Softworx\RocXolid\Forms\AbstractCrudUpdateForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// rocXolid user management form fields
use Softworx\RocXolid\UserManagement\Forms\Fields\Type\PermissionsAssignment;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Group;
use Softworx\RocXolid\UserManagement\Models\Role;
use Softworx\RocXolid\UserManagement\Models\Permission;

/**
 * User model authorization data update form.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 * @todo ugly, revise & refactor
 */
class UpdateAuthorizationData extends AbstractCrudUpdateForm
{
    /**
     * {@inheritDoc}
     */
    protected $fields = [/*
        'groups' => [
            'type' => FieldType\CollectionCheckbox::class,
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
            'type' => FieldType\CollectionCheckbox::class,
            'options' => [
                'type-template' => 'collection-checkbox-buttons',
                'label' => [
                    'title' => 'roles',
                ],
                'attributes' => [
                    // 'data-change-action' => null,
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

    /**
     * {@inheritDoc}
     */
    protected function adjustFieldsDefinition($fields)
    {
        // updating self
        // @todo kinda "hotfixed"
        if (($user = auth('rocXolid')->user()) && $user->is($this->getModel())) {
            $except = $user->roles
                ->where('is_self_unassignable', 0)
                ->merge($user->getSelfNonAssignableRoles());

            $fields['roles']['options']['collection']['filters'] = [[ 'class' => Filters\Except::class, 'data' => $except, ]];
        }

        /*
        $fields['permissions']['options'] = [
            'collection' => PermissionLoader::get(),
            'label' => [
                'title' => 'permissions',
            ],
        ];
        */

        unset($fields['permissions']); // @todo "hotfixed" for now

/*
        // $fields['roles']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());

        $roles = $this->getModel()->roles;

        // if ($this->getInputFieldValue('roles')) {
            // $roles = Role::whereIn('id', $this->getInputFieldValue('roles') ?: collect())->get();

            if ($exclusive = $roles->first(function (Role $role) {
                return $role->is_exclusive;
            })) {
                $fields['roles']['options']['collection']['filters'][] = [
                    'class' => Filters\Only::class,
                    'data' => collect([ $exclusive ]),
                ];
            };
        // }
*/
        $fields['roles']['options']['validation']['rules'][] = function ($attribute, $value, $fail) {
            $roles = Role::whereIn('id', collect($value))->where('is_exclusive', true)->get();

            if ($roles->isNotEmpty() && collect($value)->count() > 1) {
                $fail($this->getController()->translate('text.role-exclusive', [
                    'role' => $roles->transform(function (Role $role) {
                        return $role->getTitle();
                    })->join(', '),
                ]));
            }
        };

        return $fields;
    }
}
