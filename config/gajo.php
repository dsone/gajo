<?php

return [
    'contact_mail' => env('APP_CONTACT_MAIL', ''),
    'settings' => [
        // If you use this app with more than one user, set this to true
        // Otherwise only one user can register
        'multiUser' => false,
        // If multiUser is set to true, you can limit the amount of users here,
        // 0 means there is no limit
        'userLimit' => 0,
        'list' => [
            // constants, do not change
            'visibility' => [
                'hidden' => 1,
                'private' => 2,
                'public' => 4
            ]
        ]
    ],
];