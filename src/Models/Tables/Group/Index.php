<?php

namespace Softworx\RocXolid\UserManagement\Models\Tables\Group;

use Softworx\RocXolid\Tables\AbstractCrudTable;
use Softworx\RocXolid\Tables\Columns\Type\Text;
use Softworx\RocXolid\Tables\Columns\Type\ModelRelation;
use Softworx\RocXolid\Commerce\Models\Shop;

/**
 *
 */
class Index extends AbstractCrudTable
{
    protected $columns = [
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
        'webs' => [
            'type' => ModelRelation::class,
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
            'type' => ModelRelation::class,
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
}
