<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    //GOOGLE API
    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID','1092930444045-b7cmmvmoc0nm3bcu74dq0h5nt0etqi57.apps.googleusercontent.com'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET','jaBSV8qSnAbCRwE4Ex3VxfNQ'),
        'redirect'      => env('GOOGLE_REDIRECT','http://dev.miny.com/app/google/callback'),
    ],

    // FACEBOOK API
    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID','2022048144790298'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET','a688cbb40e9496d6b671df0b28f49afa'),
        'redirect' => env('FACEBOOK_REDIRECT','http://dev.miny.com/app/google/callback'),
    ],
    //SOCIAL
    'social'=>[
        'google' => env('SOCIAL_GOOGLE','https://www.googleapis.com/plus/v1/people/me?access_token='),
        'facebook' => env('SOCIAL_FACEBOOK','https://graph.facebook.com/me?access_token=')
    ]

];
