<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'admin' => [
            'all' => 'c,r,u,d',
        ],
        'owner' => [
            'quiz' => 'c,r,u,d',
            'user' => 'c,r,u,d',
        ],
        'teacher' => [
            'quiz' => 'c,r,u,d',
            'user' => 'c,r,u',
        ],
        'student' => [
            'user' => 'r',
            'quiz' => 'r',
        ],
        'guest' => [],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
