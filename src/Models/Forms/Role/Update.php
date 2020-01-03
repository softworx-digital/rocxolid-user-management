<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\Role;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;

class Update extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
    ];

    protected function adjustFieldsDefinition($fields)
    {
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

        return $fields;
    }
}