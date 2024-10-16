<?php

return [
    /**
     * Setting provider class — Required. Source of the public keys for Takeads API client.
     */
    'settings_provider' => Muscobytes\Laravel\TakeadsApi\Settings\ConfigSettings::class,

    /**
     * Takeads platform and account keys
     * You can add as many key as you need. Keys can be either platform or account specific.
     */
    'credentials' => [
        [
            'id' => env('TAKEADS_ACCOUNT_ID'),
            'public_key' => env('TAKEADS_ACCOUNT_PUBLIC_KEY')
        ],
        [
            'id' => env('TAKEADS_PLATFORM_ID'),
            'public_key' => env('TAKEADS_PLATFORM_PUBLIC_KEY')
        ],
    ]
];
