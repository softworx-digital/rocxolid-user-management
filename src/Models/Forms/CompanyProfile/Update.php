<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\CompanyProfile;

// rocXolid filters
use Softworx\RocXolid\Filters\IsEnabled;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// rocXolid form field types
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// app models
use App\Models\EnumCompanyRegistrationCourt; // @todo this doesn't belong here

class Update extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
    ];

    protected $fields = [
        'relation' => [
            'type' => FieldType\Hidden::class,
            'options' => [
                'validation' => 'required',
            ],
        ],
        'model_attribute' => [
            'type' => FieldType\Hidden::class,
            'options' => [
                'validation' => 'required',
            ],
        ],
        'name' => [
            'type' => FieldType\Input::class,
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
        'email' => [
            'type' => FieldType\Email::class,
            'options' => [
                'label' => [
                    'title' => 'email',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'email',
                    ],
                ],
            ],
        ],
        'company_registration_no' => [
            'type' => FieldType\Input::class,
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
        'company_registration_court_id' => [
            'type' => FieldType\CollectionSelect::class,
            'options' => [
                'label' => [
                    'title' => 'company_registration_court_id',
                ],
                'collection' => [
                    'model' => EnumCompanyRegistrationCourt::class,
                    'column' => 'title',
                    'filters' => [[ 'class' => IsEnabled::class, 'data' => true ]],
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'exists:enum_company_registration_courts,id',
                    ],
                ],
                'attributes' => [
                    'placeholder' => 'select',
                ],
            ],
        ],
        'company_insertion_division' => [
            'type' => FieldType\Input::class,
            'options' => [
                'label' => [
                    'title' => 'company_insertion_division',
                ],
                'value' => 'Sro', // @todo make configurable
                'validation' => [
                    'rules' => [
                        'required',
                        'max:30',
                    ],
                ],
            ],
        ],
        'company_insertion_no' => [
            'type' => FieldType\Input::class,
            'options' => [
                'label' => [
                    'title' => 'company_insertion_no',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'max:30',
                    ],
                ],
            ],
        ],
        'tax_no' => [
            'type' => FieldType\Input::class,
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
            'type' => FieldType\Input::class,
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

    protected function adjustFieldsDefinition($fields)
    {
        $fields['relation']['options']['value'] = $this->getInputFieldValue('relation');
        $fields['model_attribute']['options']['value'] = $this->getInputFieldValue('model_attribute');

        return $fields;
    }
}
