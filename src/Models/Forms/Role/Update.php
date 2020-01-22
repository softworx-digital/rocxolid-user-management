<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\Role;

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
            'label' => [
                'title' => 'permissions',
            ],
        ];
        /*
        $fields = array_merge_recursive($fields, [
            'permissions' => [
                'options' => [
                    'collection' => [
                        'method' => 'getTitle',
                    ],
                    'label' => [
                        'collection' => [
                            'attributes' => [
                                'class' => 'label-fit-height margin-left-5 margin-right-5 col-xs-4'
                            ]
                        ],
                    ],
                ],
            ],
        ]);*/
        // unset($fields['permissions']);
// dd($fields);
        return $fields;
    }
}
