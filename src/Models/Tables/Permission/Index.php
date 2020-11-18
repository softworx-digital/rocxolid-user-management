<?php

namespace Softworx\RocXolid\UserManagement\Models\Tables\Permission;

use Softworx\RocXolid\Tables\AbstractCrudTable;
use Softworx\RocXolid\Tables\Columns\Type as ColumnType;

/**
 *
 */
class Index extends AbstractCrudTable
{
    protected $columns = [
        'is_enabled' => [
            'type' => ColumnType\SwitchFlag::class,
            'options' => [
                'label' => [
                    'title' => 'is_enabled'
                ],
            ],
        ],
        'controller_class' => [
            'type' => ColumnType\Method::class,
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
            'type' => ColumnType\Text::class,
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
            'type' => ColumnType\Text::class,
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
