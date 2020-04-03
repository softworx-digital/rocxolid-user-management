<?php

namespace Softworx\RocXolid\UserManagement\Models\Tables\User;

use Softworx\RocXolid\Tables\AbstractCrudTable;
// rocXolid filters
use Softworx\RocXolid\Tables\Filters\Type\Text as TextFilter;
// use Softworx\RocXolid\Tables\Filters\Type\ModelRelation as ModelRelationFilter;
// rocXolid columns
use Softworx\RocXolid\Tables\Columns\Type\Text;
use Softworx\RocXolid\Tables\Columns\Type\Method;
use Softworx\RocXolid\Tables\Columns\Type\ImageRelation;
use Softworx\RocXolid\Tables\Columns\Type\ModelRelation;

/**
 * Default user model table.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid
 * @version 1.0.0
 */
class Index extends AbstractCrudTable
{
    protected $filters = [
        'name' => [
            'type' => TextFilter::class,
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
            'type' => TextFilter::class,
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
            'type' => ImageRelation::class,
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
            'type' => Text::class,
            'options' => [
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
            'type' => Text::class,
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
            'type' => ModelRelation::class,
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
            'type' => Method::class,
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
            'type' => Method::class,
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
            'type' => ModelRelation::class,
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
            'type' => ModelRelation::class,
            'options' => [
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
            'type' => ModelRelation::class,
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
