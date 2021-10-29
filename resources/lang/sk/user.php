<?php

return [
    'model' => [
        'title' => [
            'singular' => 'Používateľ',
            'plural' => 'Používatelia',
        ],
    ],
    'column' => [
        'groups' => 'Skupiny používateľov',
        'roles' => 'Role používateľov',
        'permissions' => 'Práva',
        'extra_permissions' => 'Extra práva',
        'last_action' => 'Posledná aktivita',
        'days_first_login' => 'Dnešné prvé prihlásenie',
        'activity' => [
            'status' => [
                'online' => 'Online',
                'offline' => 'Offline',
            ],
        ],
    ],
    'field' => [
        // 'company' => 'Údaje o spoločnosti',
        'groups' => 'Skupiny používateľov',
        'roles' => 'Role používateľov',
        'permissions' => 'Práva',
        'extra_permissions' => 'Extra práva',
        'last_action' => 'Posledná aktivita',
        'days_first_login' => 'Dnešné prvé prihlásenie',
        'remember_token' => 'Token pre zapamätanie prihlásenia',
        'email_verified_at' => 'Čas verifikácie e-mailu',
    ],
    'token' => [
        'name' => 'Meno',
        'email' => 'e-mail',
        'created_at' => 'Čas vytvorenia',
        'resetPasswordUrl' => 'URL pre reset hesla (aplikovateľné iba pri resete hesla)',
    ],
    'panel' => [
        'data' => [
            'authentication' => [
                'heading' => 'Autentifikačné údaje',
            ],
            'authorization' => [
                'heading' => 'Autorizačné údaje',
            ],
            'company' => [
                'heading' => 'Údaje o spoločnosti',
            ],
            'instagram' => [
                'heading' => 'Instagram',
            ],
            'note' => [
                'heading' => 'Poznámka',
            ],
        ],
        'activity' => [
            'heading' => 'Aktivita',
            'time' => 'Čas prihlásenia',
            'ip' => 'IPv4 adresa',
            'url' => 'URL',
            'status' => [
                'heading' => 'Stav',
                'online' => 'Online',
                'offline' => 'Offline',
            ],
        ],
    ],
    'text' => [
        'profile-data-unavailable' => 'Osobné údaje ešte nie sú vyplnené',
        //
        'role-exclusive' => 'Role [:role] sú exkluzívne a nie je možné používateľovi priradiť ďalšie.',
        //
        'salutation' => [
            'natural' => [
                'f' => 'Vážená pani :name',
                'm' => 'Vážený pán :name',
            ],
            'juridical' => 'Vážený obchodný partner :name',
        ],
    ],
];