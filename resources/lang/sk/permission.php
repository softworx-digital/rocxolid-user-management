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
        'synchronize-insert' => 'Uložiť zo zdrojového kódu',
        'synchronize-delete' => 'Vymazať prebytočné',
    ],
    'permissions' => [
        'synchronize' => 'Synchronizácia',
    ],
    'text' => [
        'out-of-sync' => 'Práva zapísané v databáze nie su zosynchronizované s Controller triedami v zdrojovom kóde.',
        'out-of-sync-saved-code' => 'Práva zapísané v databáze, ktoré nie sú v zdrojovom kóde alebo boli upravené:',
        'out-of-sync-code-saved' => 'Práva v zdrojovom kóde, ktoré nie sú zapísané v databáze alebo boli upravené:',
    ],
];