<?php
/**
 * Created by PhpStorm.
 * User: conghoan
 * Date: 7/9/18
 * Time: 08:56
 */

return [
    'url' => env('OPCACHE_URL', config('app.url')),
    'verify_ssl' => true,
    'directories' => [
        base_path('app'),
        base_path('bootstrap'),
        base_path('public'),
        base_path('resources/lang'),
        base_path('routes'),
        base_path('storage/framework/views'),
        base_path('vendor/appstract'),
        base_path('vendor/composer'),
        base_path('vendor/laravel/framework'),
    ],
];