<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\CompanyProfile;

// rocXolid form contracts
use Softworx\RocXolid\Forms\Contracts\FormField;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// rocXolid form field types
use Softworx\RocXolid\Forms\Fields\Type\Hidden;
use Softworx\RocXolid\Forms\Fields\Type\Input;
use Softworx\RocXolid\Forms\Fields\Type\Email;
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
        ],
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
        'email' => [
            'type' => Email::class,
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
        'company_insertion_no' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'company_insertion_no',
                ],
                'validation' => [
                    'rules' => [
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

    protected function adjustFieldsDefinition($fields)
    {
        $fields['user_id']['options']['value'] = $this->getInputFieldValue('user_id');
        $fields['relation']['options']['value'] = $this->getInputFieldValue('relation');
        $fields['model_attribute']['options']['value'] = $this->getInputFieldValue('model_attribute');

        return $fields;
    }
}
