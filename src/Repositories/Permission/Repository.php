<?php

namespace Softworx\RocXolid\UserManagement\Repositories\Permission;

use Softworx\RocXolid\Repositories\AbstractCrudRepository;
use Softworx\RocXolid\Repositories\Columns\Type\Text;
use Softworx\RocXolid\Repositories\Columns\Type\Method;

class Repository extends AbstractCrudRepository
{
    protected $columns = [
        'name' => [
            'type' => Method::class,
            'options' => [
                'method' => 'getTitle',
                'label' => [
                    'title' => 'name'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],/*
        'guard_name' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'guard_name'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],*//*
        'controller_class' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'controller_class'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],*/
        'controller_method_group' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'controller_method_group'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],/*
        'controller_method' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'controller_method'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],*/
    ];
}