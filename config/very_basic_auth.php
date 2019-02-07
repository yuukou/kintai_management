<?php

    /**
     * Configuration for the "HTTP Very Basic Auth"-middleware
     */
    return [
        // Username
        'user'              => 'logical_attendance',

        // Password
        'password'          => 'logical-studio',

        // Environments where the middleware is active
        'envs'              => [
            'local',
            'dev',
            'development',
            'staging',
            'production',
            'testing'
        ],

        // Message to display if the user "opts out"/clicks "cancel"
        'error_message'     => 'You have to supply your credentials to access this resource.'
    ];
