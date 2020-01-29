<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\UserProfile;

// rocXolid model scopes
use Softworx\RocXolid\Models\Scopes\Owned as OwnedScope;
// rocXolid form contracts
use Softworx\RocXolid\Forms\Contracts\FormField;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// rocXolid form field types
use Softworx\RocXolid\Forms\Fields\Type\Hidden;
use Softworx\RocXolid\Forms\Fields\Type\Input;
use Softworx\RocXolid\Forms\Fields\Type\Select;
use Softworx\RocXolid\Forms\Fields\Type\Datepicker;
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelect;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Language;
use Softworx\RocXolid\Common\Models\Nationality;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\User;

class Create extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
    ];

    protected $fields = [
        'relation' => [
            'type' => Hidden::class,
            'options' => [
                'validation' => 'required',
            ],
        ],
        'model_attribute' => [
            'type' => Hidden::class,
            'options' => [
                'validation' => 'required',
            ],
        ],
        'user_id' => [
            'type' => Hidden::class,
            'options' => [
                'validation' => 'required',
            ],
        ],
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
                        // 'required',
                        // 'date',
                    ],
                ],
                'attributes' => [
                    'placeholder' => '',
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
                        // 'required',
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
                        // 'required',
                    ],
                ],
            ],
        ],
    ];

    protected function adjustFieldsDefinition($fields)
    {
        $fields['user_id']['options']['value'] = $this->getInputFieldValue('user_id');
        $fields['relation']['options']['value'] = $this->getInputFieldValue('relation');
        $fields['model_attribute']['options']['value'] = $this->getInputFieldValue('model_attribute');

        $fields['legal_entity']['options']['choices'] = [
            'natural' => __('rocXolid:user-management::user-profile.choice.legal_entity.natural'),
            'juridical' => __('rocXolid:user-management::user-profile.choice.legal_entity.juridical'),
        ];

        $fields['gender']['options']['choices'] = [
            'm' => __('rocXolid:user-management::user-profile.choice.gender.m'),
            'f' => __('rocXolid:user-management::user-profile.choice.gender.f'),
        ];

        $fields['nationality_id']['options']['collection'] = Nationality::withoutGlobalScope(app(OwnedScope::class))->pluck('name', 'id');
        $fields['language_id']['options']['collection'] = Language::withoutGlobalScope(app(OwnedScope::class))->where('is_admin_available', 1)->pluck('name', 'id');

        return $fields;
    }
}
