<?php

/**
 *--------------------------------------------------------------------------
 * General user management configuration.
 *--------------------------------------------------------------------------
 */
return [
    /**
     * Route path for administration environment.
     */
    'routes' => [
        'login' => 'login',
        'logout' => 'logout',
        'ping' => 'ping',
        'registration' => 'registration',
        'forgot-password' => 'forgot-password',
    ],
    /**
     * View composers.
     */
    'composers' => [
        //'rocXolid::*' => Softworx\RocXolid\Admin\Composers\ViewComposer::class,
        //'rocXolid::layouts.include.sidebar' => Softworx\RocXolid\Admin\Composers\Sidebar\DefaultComposer::class,
        //'rocXolid::layouts.include.footer' => Softworx\RocXolid\Admin\Composers\Footer\DefaultComposer::class,
    ]
];