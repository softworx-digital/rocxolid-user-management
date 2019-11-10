<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\User;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type\Hidden;
use Softworx\RocXolid\Forms\Fields\Type\Input;
use Softworx\RocXolid\Forms\Fields\Type\Password;
use Softworx\RocXolid\Forms\Fields\Type\Email;
use Softworx\RocXolid\Forms\Fields\Type\Select;
use Softworx\RocXolid\Forms\Fields\Type\Datepicker;
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelect;
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelectAutocomplete;
use Softworx\RocXolid\Forms\Fields\Type\ButtonSubmit;
use Softworx\RocXolid\Common\Models\Language;
use Softworx\RocXolid\Common\Models\Nationality;
use Softworx\RocXolid\Common\Filters\CityBelongsTo;
use Softworx\RocXolid\Common\Models\Country;
use Softworx\RocXolid\Common\Models\Region;
use Softworx\RocXolid\Common\Models\District;
use Softworx\RocXolid\Common\Models\City;

class Registration extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'register',
        'class' => 'form-horizontal form-label-left',
        'show-back-button' => false,
    ];

    protected $fields = [
        'first_name' => [
            'type' => Input::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                        'max:255',
                    ],
                ],
                'attributes' => [
                    'placeholder' => 'first_name',
                ],
            ],
        ],
        'last_name' => [
            'type' => Input::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                        'max:255',
                    ],
                ],
                'attributes' => [
                    'placeholder' => 'last_name',
                ],
            ],
        ],
        'email' => [
            'type' => Email::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                        'email',
                        'unique:users,email',
                    ],
                ],
                'attributes' => [
                    'placeholder' => 'email',
                ],
            ],
        ],
        'password' => [
            'type' => Password::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                        'max:255',
                        'min:6',
                        //'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/',
                        'confirmed',
                    ],
                ],
                'attributes' => [
                    'placeholder' => 'password',
                ],
            ],
        ],
        'password_confirmation' => [
            'type' => Password::class,
            'options' => [
                'attributes' => [
                    'placeholder' => 'password_confirmation',
                ],
            ],
        ],
        'birthdate' => [
            'type' => Datepicker::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                        'date',
                    ],
                ],
                'attributes' => [
                    'placeholder' => 'birthdate',
                ],
            ],
        ],
        'language_id' => [
            'type' => CollectionSelect::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
                'attributes' => [
                    'placeholder' => 'language',
                ],
            ],
        ],
    ];

    protected $buttons = [
        'submit' => [
            'type' => ButtonSubmit::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'register',
                ],
                'attributes' => [
                    'class' => 'btn btn-primary',
                ],
            ],
        ],
    ];

    protected function adjustFieldsDefinition($fields)
    {
        // language
        $fields['language_id']['options']['collection'] = Language::where('is_admin_available', 1)->pluck('name', 'id');

        return $fields;
    }
}