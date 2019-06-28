<?php
/**
 * Created by PhpStorm.
 * User: huyptit
 * Date: 13/02/2019
 * Time: 13:01
 */

return array(

    /*
    |--------------------------------------------------------------------------
    | Name of route
    |--------------------------------------------------------------------------
    |
    | Enter the routes name to enable dynamic imagecache manipulation.
    | This handle will define the first part of the URI:
    |
    | {route}/{template}/{filename}
    |
    | Examples: "images", "img/cache"
    |
    */

    'route' => 'images',

    /*
    |--------------------------------------------------------------------------
    | Storage paths
    |--------------------------------------------------------------------------
    |
    | The following paths will be searched for the image filename, submited
    | by URI.
    |
    | Define as many directories as you like.
    |
    */

    'paths' => array(
        public_path('images'),
        storage_path('images'),
    ),

    /*
    |--------------------------------------------------------------------------
    | Manipulation templates
    |--------------------------------------------------------------------------
    |
    | Here you may specify your own manipulation filter templates.
    | The keys of this array will define which templates
    | are available in the URI:
    |
    | {route}/{template}/{filename}
    |
    | The values of this array will define which filter class
    | will be applied, by its fully qualified name.
    |
    */
//    config('imagecache')['templates']['cc_mobile']

    'templates' => array(
        'small' => 'App\Core\ImageTemplate\Small',
        'medium' => 'App\Core\ImageTemplate\Medium',
        'large' => 'App\Core\ImageTemplate\Large',
        'sidebar_large' => 'App\Core\ImageTemplate\ImageSidebarLarge',
        'sidebar_small' => 'App\Core\ImageTemplate\ImageSidebarSmall',
        'image_show_small' => 'App\Core\ImageTemplate\ImageShowSmall',
    ),

    /*
    |--------------------------------------------------------------------------
    | Image Cache Lifetime
    |--------------------------------------------------------------------------
    |
    | Lifetime in minutes of the images handled by the imagecache route.
    |
    */

    'lifetime' => 43200,

);
