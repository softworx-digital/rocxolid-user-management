<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\UserProfile;

// rocXolid forms & related
use Softworx\RocXolid\Forms\AbstractCrudCreateForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;

/**
 * UserProfile model create form.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
class Create extends AbstractCrudCreateForm
{
    /**
     * {@inheritDoc}
     */
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
        'user_id' => [
            'type' => FieldType\Hidden::class,
            'options' => [
                'validation' => 'required',
            ],
        ],
        'legal_entity' => [
            'type' => FieldType\CollectionRadioList::class,
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
            'type' => FieldType\Input::class,
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
            'type' => FieldType\Input::class,
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
            'type' => FieldType\CollectionSelect::class,
            'options' => [
                'label' => [
                    'title' => 'nationality',
                ],
            ],
        ],
        'language_id' => [
            'type' => FieldType\CollectionSelect::class,
            'options' => [
                'label' => [
                    'title' => 'language',
                ],
            ],
        ],
        'birthdate' => [
            'type' => FieldType\Datepicker::class,
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
            'type' => FieldType\CollectionRadioList::class,
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
            'type' => FieldType\Input::class,
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
            'type' => FieldType\Input::class,
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

    /**
     * {@inheritDoc}
     */
    protected function adjustFieldsDefinition(array $fields): array
    {
        $fields['user_id']['options']['value'] = $this->getInputFieldValue('user_id');
        $fields['relation']['options']['value'] = $this->getInputFieldValue('relation');
        $fields['model_attribute']['options']['value'] = $this->getInputFieldValue('model_attribute');
        //
        $fields['legal_entity']['options']['collection'] = collect([ 'natural', 'juridical' ])->mapWithKeys(function (string $choice) {
            return [ $choice => $this->getController()->translate(sprintf('choice.legal_entity.%s', $choice)) ];
        });
        //
        $fields['gender']['options']['collection'] = collect([ 'm', 'f' ])->mapWithKeys(function (string $choice) {
            return [ $choice => $this->getController()->translate(sprintf('choice.gender.%s', $choice)) ];
        });
        //
        $fields['nationality_id']['options']['collection'] = $this->getModel()->nationality()->getRelated()->pluck('name', 'id');
        $fields['language_id']['options']['collection'] = $this->getModel()->language()->getRelated()->where('is_admin_available', 1)->pluck('name', 'id');

        return $fields;
    }
}
