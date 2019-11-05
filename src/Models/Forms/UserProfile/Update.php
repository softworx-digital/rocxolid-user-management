<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\UserProfile;

use Illuminate\Validation\Rule;
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type\Input;
use Softworx\RocXolid\Forms\Fields\Type\Email;
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelect;
use Softworx\RocXolid\Forms\Fields\Type\CollectionCheckbox;
use Softworx\RocXolid\Common\Models\Language;

class Update extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
    ];

    protected $fields = [
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
        'language_id' => [
            'type' => CollectionSelect::class,
            'options' => [
                'label' => [
                    'title' => 'language',
                ],
            ],
        ],
    ];

    protected function adjustFieldsDefinition($fields)
    {
        $fields['language_id']['options']['collection'] = Language::where('is_admin_available', 1)->pluck('name', 'id');

        $rule = Rule::unique('users', 'email')
            ->ignore($this->getModel()->id);

        $fields = array_merge_recursive($fields, [
            'email' => [
                'options' => [
                    'validation' => [
                        'rules' => [
                            $rule
                        ],
                    ],
                ],
            ],
        ]);

        return $fields;
    }
}