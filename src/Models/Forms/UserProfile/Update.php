<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\UserProfile;

use Illuminate\Support\Collection;
use Softworx\RocXolid\Forms\Contracts\FormField;
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type\Hidden;
use Softworx\RocXolid\Forms\Fields\Type\Input;
use Softworx\RocXolid\Forms\Fields\Type\Email;
use Softworx\RocXolid\Forms\Fields\Type\Select;
use Softworx\RocXolid\Forms\Fields\Type\Datepicker;
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelect;
use Softworx\RocXolid\Common\Models\Language;
use Softworx\RocXolid\Common\Models\Nationality;
use Softworx\RocXolid\UserManagement\Models\User;

class Update extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
    ];

    protected $fields = [
        'legal_entity' => [
            'type' => Select::class,
            'options' => [
                // 'choices' => ...adjusted
                'label' => [
                    'title' => 'legal_entity',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'in:natural,juridical'
                    ],
                ],
            ],
        ],
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
        'bank_account_no' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'bank_account_no',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
        'phone_no' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'phone_no',
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
        $fields['legal_entity']['options']['choices'] = [
            'natural' => __('rocXolid:user-management::user-profile.choice.legal_entity.natural'),
            'juridical' => __('rocXolid:user-management::user-profile.choice.legal_entity.juridical'),
        ];

        $fields['gender']['options']['choices'] = [
            'm' => __('rocXolid:user-management::user-profile.choice.gender.m'),
            'f' => __('rocXolid:user-management::user-profile.choice.gender.f'),
        ];

        $fields['nationality_id']['options']['collection'] = Nationality::pluck('name', 'id');
        $fields['language_id']['options']['collection'] = Language::where('is_admin_available', 1)->pluck('name', 'id');

        return $fields;
    }
}