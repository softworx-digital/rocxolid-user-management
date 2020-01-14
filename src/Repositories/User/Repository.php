<?php

namespace Softworx\RocXolid\UserManagement\Repositories\User;

use Softworx\RocXolid\Repositories\AbstractCrudRepository;
use Softworx\RocXolid\Repositories\Columns\Type\Text;
use Softworx\RocXolid\Repositories\Columns\Type\Method;
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
                'method' => 'getLastAction',
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'status' => [
            'type' => Method::class,
            'options' => [
                'label' => [
                    'title' => 'status'
                ],
                'method' => 'getStatus',
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],*/
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
        ],
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
        ],
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
}
