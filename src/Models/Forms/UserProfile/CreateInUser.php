<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\UserProfile;

use Illuminate\Support\Collection;
use Softworx\RocXolid\Forms\Contracts\FormField;
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type\Hidden;
use Softworx\RocXolid\Forms\Fields\Type\Input;
use Softworx\RocXolid\Forms\Fields\Type\Email;
use Softworx\RocXolid\Forms\Fields\Type\Select;
use Softworx\RocXolid\Forms\Fields\Type\Datepicker;
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelect;
use Softworx\RocXolid\Common\Models\Language;
use Softworx\RocXolid\Common\Models\Nationality;
use Softworx\RocXolid\UserManagement\Models\User;

class CreateInUser extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
        'section' => 'profile-data',
    ];

    protected $fields = [
        'user_id' => [
            'type' => Hidden::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
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
        'company_name' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'company_name',
                ],
                'validation' => [
                    'rules' => [
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
                        'required',
                        'date',
                    ],
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
                        'required',
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
                        'required',
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

        $fields = array_merge_recursive($fields, [
            'user_id' => [
                'options' => [
                    'value' => $user->id,
                ],
            ],
        ]);

        $fields['gender']['options']['choices'] = [
            'm' => __('rocXolid:user-management::general.text.male'),
            'f' => __('rocXolid:user-management::general.text.female'),
        ];
        $fields['nationality_id']['options']['collection'] = Nationality::pluck('name', 'id');
        $fields['language_id']['options']['collection'] = Language::where('is_admin_available', 1)->pluck('name', 'id');

        return $fields;
    }
}