<?php

return [
    'column' => [
        'name' => 'Názov',
        'guard' => 'Guard',
        'package' => 'Package',
        'controller_class' => 'Controller',
        'policy_ability_group' => 'Skupina akcií',
        'policy_ability' => 'Akcia',
    ],
    'field' => [
        'name' => 'Názov',
        'guard' => 'Guard',
        'package' => 'Package',
        'controller_class' => 'Controller',
        'policy_ability_group' => 'Skupina akcií',
        'policy_ability' => 'Akcia',
    ],
    'model' => [
        'title' => [
            'singular' => 'Právo používateľov administrácie',
            'plural' => 'Práva používateľov administrácie',
        ],
    ],
    'method-group' => [
        'read-only' => 'čítanie',
        'write' => 'zápis',
    ],
    'button' => [
        'synchronize' => 'Synchronizovať',
    ],
    'text' => [
        'out-of-sync' => 'Práva zapísané v databáze nie su zosynchronizované s Controller triedami v zdrojovom kóde.',
    ],
];