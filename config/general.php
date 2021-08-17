<?php

/**
 *--------------------------------------------------------------------------
 * General user management configuration.
 *--------------------------------------------------------------------------
 */
return [
    /**
     * View composers.
     */
    'composers' => [
        'rocXolid:user-management::*' => Softworx\RocXolid\UserManagement\Composers\ViewComposer::class,
    ],
];