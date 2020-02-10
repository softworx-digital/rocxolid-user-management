<?php

return [
    'column' => [
        'name' => 'Name',
        'guard' => 'Guard',
        'package' => 'Package',
        'controller_class' => 'Controller',
        'policy_ability_group' => 'Actions group',
        'policy_ability' => 'Action',
    ],
    'field' => [
        'name' => 'Name',
        'guard' => 'Guard',
        'package' => 'Package',
        'controller_class' => 'Controller',
        'policy_ability_group' => 'Actions group',
        'policy_ability' => 'Action',
    ],
    'model' => [
        'title' => [
            'singular' => 'Permission',
            'plural' => 'Permissions',
        ],
    ],
    'method-group' => [
        'read-only' => 'read-only',
        'write' => 'write',
    ],
    'button' => [
        'synchronize' => 'Synchronize',
    ],
    'permissions' => [
        'synchronize' => 'Synchronization',
    ],
    'text' => [
        'out-of-sync' => 'Persistent permissions data is out of sync with source code permissions.',
        'out-of-sync-saved-code' => 'Persisted permissions not in source code or were modified:',
        'out-of-sync-code-saved' => 'Source code permissions not persisted or were modified:',
    ],
];