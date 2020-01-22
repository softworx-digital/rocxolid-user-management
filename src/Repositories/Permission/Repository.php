<?php

namespace Softworx\RocXolid\UserManagement\Repositories\Permission;

use Softworx\RocXolid\Repositories\AbstractCrudRepository;
use Softworx\RocXolid\Repositories\Columns\Type\Text;
use Softworx\RocXolid\Repositories\Columns\Type\Flag;
use Softworx\RocXolid\Repositories\Columns\Type\Method;

class Repository extends AbstractCrudRepository
{
    protected $columns = [
        'is_enabled' => [
            'type' => Flag::class,
            'options' => [
                'label' => [
                    'title' => 'is_enabled'
                ],
            ],
        ],
        'controller_class' => [
            'type' => Method::class,
            'options' => [
                'method' => 'getTitle',
                'label' => [
                    'title' => 'controller_class'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'policy_ability_group' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'policy_ability_group'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'policy_ability' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'policy_ability'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
    ];
}
