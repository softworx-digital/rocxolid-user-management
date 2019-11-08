<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\CompanyProfile;

use Illuminate\Support\Collection;
use Softworx\RocXolid\Forms\Contracts\FormField;
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type\Hidden;
use Softworx\RocXolid\Forms\Fields\Type\Input;
use Softworx\RocXolid\UserManagement\Models\User;

class Create extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
    ];

    protected $fields = [
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
        'tax_id' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'tax_id',
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
        $input = new Collection($this->getRequest()->input());

        if (!$input->has(FormField::SINGLE_DATA_PARAM))
        {
            throw new \InvalidArgumentException(sprintf('Undefined [%s] param in request', FormField::SINGLE_DATA_PARAM));
        }

        $input = new Collection($input->get(FormField::SINGLE_DATA_PARAM));

        if (!$user = User::find($input->get('user_id')))
        {
            throw new \InvalidArgumentException(sprintf('Invalid user_id [%s]', $input->get('user_id')));
        }

        $fields['user_id']['options']['value'] = $user->id;

        return $fields;
    }
}