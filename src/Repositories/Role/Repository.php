<?php

namespace Softworx\RocXolid\UserManagement\Repositories\Role;

use Softworx\RocXolid\Repositories\AbstractCrudRepository;
use Softworx\RocXolid\Repositories\Columns\Type\Text;
use Softworx\RocXolid\Repositories\Columns\Type\Flag;
use Softworx\RocXolid\Repositories\Columns\Type\ModelRelation;

class Repository extends AbstractCrudRepository
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
        'is_self_assignable' => [
            'type' => Flag::class,
            'options' => [
                'label' => [
                    'title' => 'is_self_assignable'
                ],
            ],
        ],
        'is_self_unassignable' => [
            'type' => Flag::class,
            'options' => [
                'label' => [
                    'title' => 'is_self_unassignable'
                ],
            ],
        ],/*
        'guard' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'guard'
                ],
            ],
        ],
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
