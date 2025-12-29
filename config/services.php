<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'dotflo' => [
        'base_url' => env('APP_URL', 'http://dotflo.org'),
    ],

    'meta_app_id' => env('META_APP_ID'),
    'meta_app_token' => env('META_APP_TOKEN'),

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT'),
        'ad_client_id' => env('FACEBOOK_ADS_CLIENT_ID'),
        'ad_client_secret' => env('FACEBOOK_ADS_CLIENT_SECRET'),
        'ad_redirect' => env('FACEBOOK_ADS_REDIRECT'),
        'app_id' => env('FACEBOOK_APP_ID', ''),
        'app_secret' => env('FACEBOOK_APP_SECRET', ''),
        'config_id' => env('FACEBOOK_CONFIG_ID', ''),
        'verify_token' => env('FACEBOOK_VERIFY_TOKEN'),
    ],
];
