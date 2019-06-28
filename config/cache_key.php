    <?php
/**
 * Created by PhpStorm.
 * User: hocvt
 * Date: 1/20/17
 * Time: 08:52
 */

return [
    'header_cates' => [
        'schedule' => true,
        'name' => 'header_cates',
        'timeout' => '60',
        'time_schedule' => 50,
        'class' => \App\Colombo\Cache\CategoryCache::class,
        'refresh_method' => 'getFrontendHeaderCategories',
    ],
    'footer_cates' => [
        'schedule' => true,
        'name' => 'footer_cates',
        'timeout' => '60',
        'time_schedule' => 50,
        'class' => \App\Colombo\Cache\CategoryCache::class,
        'refresh_method' => 'getFrontendFooterCategories',
    ],
    'cates_posts' => [
        'schedule' => true,
        'name' => 'cates_posts',
        'timeout' => '20',
        'time_schedule' => 15,
        'class' => \App\Colombo\Cache\PostCache::class,
        'refresh_method' => 'getHomeCategoryPosts',
    ],
    'equation_demo' => [
        'schedule' => true,
        'name' => 'equation_demo',
        'timeout' => '20',
        'time_schedule' => 15,
        'class' => \App\Colombo\Cache\EquationCache::class,
        'refresh_method' => 'getEquationDemo',
    ],

];