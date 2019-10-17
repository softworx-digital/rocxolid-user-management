<?php

/**
 *--------------------------------------------------------------------------
 * Authorization configuration.
 *--------------------------------------------------------------------------
 */
return [

    'guards' => [
        'rocXolid' => [
            'driver' => 'session',
            'provider' => 'rocXolid',
        ],
    ],

    'providers' => [
        'rocXolid' => [
            'driver' => 'eloquent',
            'model' => \Softworx\RocXolid\UserManagement\Models\User::class,
        ],
    ],

];
