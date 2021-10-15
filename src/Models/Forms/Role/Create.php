<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\Role;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;

class Create extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
    ];

    protected function adjustFieldsDefinition(array $fields): array
    {
        /*
        $fields = array_merge_recursive($fields, [
            'permissions' => [
                'options' => [
                    'collection' => [
                        'method' => 'getTitle',
                    ],
                ],
            ],
        ]);
        */
        unset($fields['permissions']);

        return $fields;
    }
}
