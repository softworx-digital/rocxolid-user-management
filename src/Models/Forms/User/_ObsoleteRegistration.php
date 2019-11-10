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
        // 'route-action' => 'registration',
        'class' => '',
        'show-back-button' => false,
    ];

    protected $fields = [
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
        'legal_entity' => [
            'type' => Select::class,
            'options' => [
                // 'choices' => ...adjusted
                'validation' => [
                    'rules' => [
                        'required',
                        'in:natural,juridical'
                    ],
                ],
                'attributes' => [
                    'placeholder' => 'legal_entity',
                ],
            ],
        ],
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
        'nationality_id' => [
            'type' => CollectionSelect::class,
            'options' => [
                'attributes' => [
                    'placeholder' => 'nationality',
                ],
            ],
        ],
        'language_id' => [
            'type' => CollectionSelect::class,
            'options' => [
                'attributes' => [
                    'placeholder' => 'language',
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
        'gender' => [
            'type' => Select::class,
            'options' => [
                // 'choices' => ...adjusted
                'validation' => [
                    'rules' => [
                        'required',
                        'in:m,f'
                    ],
                ],
                'attributes' => [
                    'placeholder' => 'gender',
                ],
            ],
        ],
        'bank_account_no' => [
            'type' => Input::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
                'attributes' => [
                    'placeholder' => 'bank_account_no',
                ],
            ],
        ],
        'phone_no' => [
            'type' => Input::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
                'attributes' => [
                    'placeholder' => 'phone_no',
                ],
            ],
        ],
        'company_name' => [
            'type' => Input::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'max:255',
                    ],
                ],
                'attributes' => [
                    'placeholder' => 'company_name',
                ],
            ],
        ],
        'company_registration_no' => [
            'type' => Input::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                        'max:255',
                    ],
                ],
                'attributes' => [
                    'placeholder' => 'company_registration_no',
                ],
            ],
        ],
        'tax_no' => [
            'type' => Input::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                        'max:255',
                    ],
                ],
                'attributes' => [
                    'placeholder' => 'tax_no',
                ],
            ],
        ],
        'vat_no' => [
            'type' => Input::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'max:255',
                        'euvat',
                    ],
                ],
                'attributes' => [
                    'placeholder' => 'vat_no',
                ],
            ],
        ],
        'street_name' => [
            'type' => Input::class,
            'options' => [
                'attributes' => [
                    'placeholder' => 'street_name',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'max:255',
                    ],
                ],
            ],
        ],
        'street_no' => [
            'type' => Input::class,
            'options' => [
                'attributes' => [
                    'placeholder' => 'street_no',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'max:255',
                    ],
                ],
            ],
        ],
        'zip' => [
            'type' => Input::class,
            'options' => [
                'attributes' => [
                    'placeholder' => 'zip',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'max:255',
                    ],
                ],
            ],
        ],
        'city_id' => [
            'type' => CollectionSelectAutocomplete::class,
            'options' => [
                'collection' => [
                    'model' => City::class,
                    'column' => 'name',
                    'method' => 'getSelectOption',
                ],
                'attributes' => [
                    'placeholder' => 'city',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
        'region_id' => [
            'type' => CollectionSelect::class,
            'options' => [
                'collection' => [
                    'model' => Region::class,
                    'column' => 'name',
                ],
                'attributes' => [
                    'placeholder' => 'region',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
        'district_id' => [
            'type' => CollectionSelect::class,
            'options' => [
                'collection' => [
                    'model' => District::class,
                    'column' => 'name',
                ],
                'attributes' => [
                    'placeholder' => 'district',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
        'country_id' => [
            'type' => CollectionSelect::class,
            'options' => [
                'collection' => [
                    'model' => Country::class,
                    'column' => 'name',
                ],
                'attributes' => [
                    'placeholder' => 'country',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                    ],
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
        $fields['gender']['options']['choices'] = [
            'm' => __('rocXolid:user-management::user-profile.choice.gender.m'),
            'f' => __('rocXolid:user-management::user-profile.choice.gender.f'),
        ];

        // nationality
        $fields['nationality_id']['options']['collection'] = Nationality::pluck('name', 'id');

        // language
        $fields['language_id']['options']['collection'] = Language::where('is_admin_available', 1)->pluck('name', 'id');
        
        // city
        $city = City::find($this->getInputFieldValue('city_id'));

        $fields['city_id']['options']['attributes']['data-abs-ajax-url'] = $this->getController()->getRoute('repositoryAutocomplete', ['f' => 'city_id']);
        $fields['city_id']['options']['collection']['method'] = 'getSelectOption';
        $fields['city_id']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload');

        if (!is_null($city)) {
            $fields['region_id']['options']['attributes']['placeholder'] = null;
            $fields['district_id']['options']['attributes']['placeholder'] = null;
            $fields['country_id']['options']['attributes']['placeholder'] = null;
        }

        // region
        $fields['region_id']['options']['collection']['filters'][] = ['class' => CityBelongsTo::class, 'data' => $city];
        // district
        $fields['district_id']['options']['collection']['filters'][] = ['class' => CityBelongsTo::class, 'data' => $city];
        // country
        $fields['country_id']['options']['collection']['filters'][] = ['class' => CityBelongsTo::class, 'data' => $city];

        return $fields;
    }
}