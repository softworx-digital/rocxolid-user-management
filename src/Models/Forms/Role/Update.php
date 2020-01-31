<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\Role;

use PermissionLoader;
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\UserManagement\Forms\Fields\Type\PermissionsAssignment;

class Update extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
    ];

    protected function adjustFieldsDefinition($fields)
    {
        $fields['permissions']['type'] = PermissionsAssignment::class;
        $fields['permissions']['options'] = [
            'collection' => PermissionLoader::get(),
            'label' => [
                'title' => 'permissions',
                'hint' => 'hint.permissions',
            ],
        ];

        return $fields;
    }
}
