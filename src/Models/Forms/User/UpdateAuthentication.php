<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\User;

use Illuminate\Support\Collection;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// rocXolid form field types
use Softworx\RocXolid\Forms\Fields\Type as FieldType;

class UpdateAuthentication extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
        'section' => 'authentication-data',
    ];

    protected $fields = [
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
                        // 'unique:users,email',
                    ],
                ],
            ],
        ],
        'password' => [
            'type' => FieldType\Password::class,
            'options' => [
                'label' => [
                    'title' => 'password'
                ],
                'validation' => [
                    'rules' => [
                        // 'required',
                        'nullable',
                        'max:255',
                        'min:6',
                        //'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/',
                        'confirmed',
                    ],
                ],
            ],
        ],
        'password_confirmation' => [
            'type' => FieldType\Password::class,
            'options' => [
                'label' => [
                    'title' => 'password_confirmation'
                ],
            ],
        ],
    ];

    /**
     * {@inheritDoc}
     */
    protected function adjustFieldsDefinition($fields)
    {
        $user = auth('rocXolid')->user();

        if ($user && $user->can('update', $this->getModel()) && $user->can('viewAnyAll', $this->getModel())) {
            $fields['email']['options']['validation']['rules'][] = sprintf('unique:users,email,%s', $this->getModel()->getKey());
        } else {
            unset($fields['email']);

            $fields['password']['options']['validation']['rules'][] = 'required';
        }

        return $fields;
    }

    /**
     * {@inheritDoc}
     */
    public function getFormFieldsValues(): Collection
    {
        $values = parent::getFormFieldsValues();
        $values = $values->filter();

        return $values;
    }
}
