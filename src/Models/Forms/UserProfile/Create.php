<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\UserProfile;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type\Input;
use Softworx\RocXolid\Forms\Fields\Type\Email;
use Softworx\RocXolid\Forms\Fields\Type\Select;
use Softworx\RocXolid\Forms\Fields\Type\Datepicker;
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelect;
use Softworx\RocXolid\Common\Models\Language;
use Softworx\RocXolid\Common\Models\Nationality;

class Create extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
    ];

    protected $fields = [
        'first_name' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'first_name',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'max:255',
                    ],
                ],
            ],
        ],
        'last_name' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'last_name',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'max:255',
                    ],
                ],
            ],
        ],
        'company_name' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'company_name',
                ],
                'validation' => [
                    'rules' => [
                        'max:255',
                    ],
                ],
            ],
        ],
        'nationality_id' => [
            'type' => CollectionSelect::class,
            'options' => [
                'label' => [
                    'title' => 'nationality',
                ],
            ],
        ],
        'language_id' => [
            'type' => CollectionSelect::class,
            'options' => [
                'label' => [
                    'title' => 'language',
                ],
            ],
        ],
        'birthdate' => [
            'type' => Datepicker::class,
            'options' => [
                'label' => [
                    'title' => 'birthdate',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'date',
                    ],
                ],
            ],
        ],
        'gender' => [
            'type' => Select::class,
            'options' => [
                // 'choices' => ...adjusted
                'label' => [
                    'title' => 'gender',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'in:m,f'
                    ],
                ],
            ],
        ],
        'bank_account' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'bank_account',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
        'phone' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'phone',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
    ];

    protected function adjustFieldsDefinition($fields)
    {
        $fields['gender']['options']['choices'] = [
            'm' => __('rocXolid:user-management::general.text.male'),
            'f' => __('rocXolid:user-management::general.text.female'),
        ];
        $fields['nationality_id']['options']['collection'] = Nationality::pluck('name', 'id');
        $fields['language_id']['options']['collection'] = Language::where('is_admin_available', 1)->pluck('name', 'id');

        return $fields;
    }
}