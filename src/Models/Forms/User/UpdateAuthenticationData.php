<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\User;

use Illuminate\Support\Collection;
// rocXolid forms & related
use Softworx\RocXolid\Forms\AbstractCrudUpdateForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;

/**
 * User model authentication data update form.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
class UpdateAuthenticationData extends AbstractCrudUpdateForm
{
    /**
     * {@inheritDoc}
     */
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
     * @todo hotfixed to enable empty password if not changing, you can do better
     */
    public function getFormFieldsValues(): Collection
    {
        $values = parent::getFormFieldsValues();
        $values = $values->filter();

        return $values;
    }
}
