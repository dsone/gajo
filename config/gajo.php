<?php

return [
    'contact_mail' => env('APP_CONTACT_MAIL', ''),
    'settings' => [
        /*
		 * If you use this app with more than one user, set this to true for unlimited users.
		 * Set it to a number to limit a certain amount of users.
		 * If set to false, only one user can register.
		 */
        'multiUser' => env('GAJO_MULTIUSER', false),
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