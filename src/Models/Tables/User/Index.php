<?php

namespace Softworx\RocXolid\UserManagement\Models\Tables\User;

// rocXolid tables & types
use Softworx\RocXolid\Tables\AbstractCrudTable;
use Softworx\RocXolid\Tables\Filters\Type as FilterType;
use Softworx\RocXolid\Tables\Columns\Type as ColumnType;
use Softworx\RocXolid\Tables\Buttons\Type as ButtonType;

/**
 * Default user model table.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
class Index extends AbstractCrudTable
{
    protected $filters = [
        'name' => [
            'type' => FilterType\Text::class,
            'options' => [
                'label' => [
                    'title' => 'name'
                ],
                'attributes' => [
                    'placeholder' => 'name'
                ],
            ],
        ],
        'email' => [
            'type' => FilterType\Text::class,
            'options' => [
                'label' => [
                    'title' => 'email'
                ],
                'attributes' => [
                    'placeholder' => 'email'
                ],
            ],
        ],
    ];

    protected $columns = [
        'image' => [
            'type' => ColumnType\ImageRelation::class,
            'options' => [
                'label' => [
                    'title' => 'image'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
                'size' => 'thumb',
                'relation' => [
                    'name' => 'image',
                ],
                'width' => 64,
            ],
        ],
        'status' => [
            'type' => Columns\Type\IsOnline::class,
            'options' => [
                'label' => [
                    'title' => 'status'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'name' => [
            'type' => ColumnType\Text::class,
            'options' => [
                'orderable' => true,
                'label' => [
                    'title' => 'name'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'email' => [
            'type' => ColumnType\Text::class,
            'options' => [
                'label' => [
                    'title' => 'email'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],/*
        'language' => [
            'type' => ColumnType\ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'language'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
                'relation' => [
                    'name' => 'language',
                    'column' => 'name',
                ],
            ],
        ],
        'last_action' => [
            'type' => ColumnType\Method::class,
            'options' => [
                'label' => [
                    'title' => 'last_action'
                ],
                'method' => 'getLastActivity',
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        *//*
        'days_first_login' => [
            'type' => ColumnType\Method::class,
            'options' => [
                'label' => [
                    'title' => 'days_first_login'
                ],
                'method' => 'getDaysFirstLogin',
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],*//*
        'groups' => [
            'type' => ColumnType\ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'groups'
                ],
                'relation' => [
                    'name' => 'groups',
                    'column' => 'name',
                ],
            ],
        ],*/
        'roles' => [
            'type' => ColumnType\ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'roles'
                ],
                'relation' => [
                    'name' => 'roles',
                    'column' => 'name',
                ],
            ],
        ],/*
        'permissions' => [
            'type' => ColumnType\ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'permissions'
                ],
                'relation' => [
                    'name' => 'permissions',
                    'column' => 'name',
                ],
            ],
        ],*/
    ];

    protected function getButtonsDefinition()
    {
        unset($this->buttons['show-modal']);
        unset($this->buttons['edit']);

        return $this->buttons;
    }
}
