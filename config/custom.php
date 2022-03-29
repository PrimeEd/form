<?php

return [
    'where-to-send-email' => env('APP_RX_EMAIL', 'null@null.com'),
    'google'              => [
        'drive' => [
            'client' => env('GOOGLE_DRIVE_CLIENT_FILENAME', 'client_secret.json'),
            'user'   => env('GOOGLE_DRIVE_USER_FILENAME', 'user.json'),
        ]
    ]
];
