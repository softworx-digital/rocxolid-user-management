<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\CompanyProfile;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type\Input;

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
        'company_registration_no' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'company_registration_no',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'max:255',
                    ],
                ],
            ],
        ],
        'tax_no' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'tax_no',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'max:255',
                    ],
                ],
            ],
        ],
        'vat_no' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'vat_no',
                ],
                'validation' => [
                    'rules' => [
                        'max:255',
                        'euvat',
                    ],
                ],
            ],
        ],
    ];
}
