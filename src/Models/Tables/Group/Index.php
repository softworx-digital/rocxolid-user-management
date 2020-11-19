<?php

namespace Softworx\RocXolid\UserManagement\Models\Tables\Group;

// rocXolid tables
use Softworx\RocXolid\Tables\AbstractCrudTable;
use Softworx\RocXolid\Tables\Columns\Type as ColumnType;

/**
 *
 */
class Index extends AbstractCrudTable
{
    protected $columns = [
        'name' => [
            'type' => ColumnType\Text::class,
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
        'webs' => [
            'type' => ColumnType\ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'webs'
                ],
                'relation' => [
                    'name' => 'webs',
                    'column' => 'name',
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'users' => [
            'type' => ColumnType\ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'users'
                ],
                'relation' => [
                    'name' => 'users',
                    'column' => 'aaaa',
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
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
}
