let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/frontend/js/app.js', 'public/frontend/js')
   .sass('resources/assets/frontend/sass/app.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/app_equation.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/equation/page/index.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/equation/page/equation_detail.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/equation/page/list_by_cate.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/equation/page/list_by_search.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/equation/page/list_reactant.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/equation/page/list_product.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/equation/page/chemical.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/equation/page/chemical_detail.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/equation/page/chemical_search_result.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/equation/page/periodic_table_tool.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/equation/page/reactivityseries_table_tool.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/equation/page/dissolubility_table_tool.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/equation/page/electrochemical_table_tool.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/page_first_screen/home.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/page_first_screen/detail_post.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/page_first_screen/cate_index1.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/page_first_screen/cate_index2.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/page_first_screen/cate_index3.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/page_first_screen/search_result.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/page_first_screen/flash_question_index1.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/page_first_screen/flash_question_index2.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/page_first_screen/admission_home.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/page_first_screen/admission_list_university.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/page_first_screen/admission_list_news.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/page_first_screen/admission_advice.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/page_first_screen/admission_university.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/page_first_screen/admission_news_topic.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/page_first_screen/admission_post_detail.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/page_first_screen/university_detail.scss', 'public/frontend/css').options({
    processCssUrls: false
})
mix.sass('resources/assets/frontend/sass/page_first_screen/university_news.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/page_first_screen/university_score.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass/page_first_screen/university_image.scss', 'public/frontend/css').options({
    processCssUrls: false
});
mix.sass('resources/assets/frontend/sass//category_sidebar.scss', 'public/frontend/css').options({
    processCssUrls: false
});

mix.copyDirectory('resources/assets/frontend/img', 'public/frontend/img');
mix.copyDirectory('resources/assets/frontend/plugins', 'public/frontend/plugins');
mix.copyDirectory('resources/assets/frontend/fonts', 'public/frontend/fonts');
mix.copyDirectory('resources/assets/frontend/landingPage', 'public/frontend/landingPage');
mix.js('resources/assets/backend/js/validate_title_post.js', 'public/backend/js');
mix.js('resources/assets/frontend/js/detail.post.js', 'public/frontend/js');
mix.js('resources/assets/frontend/js/category_manager.js', 'public/frontend/js');
mix.js('resources/assets/frontend/js/save_status_question.js', 'public/frontend/js');
mix.js('resources/assets/frontend/js/equation_detail.js', 'public/frontend/js');
mix.js('resources/assets/frontend/js/equation_index.js', 'public/frontend/js');
mix.js('resources/assets/frontend/js/periodic_table.js', 'public/frontend/js');
mix.js('resources/assets/frontend/js/reactivity_table.js', 'public/frontend/js');
mix.js('resources/assets/frontend/js/equation_menu.js', 'public/frontend/js');
mix.js('resources/assets/frontend/js/paginate_responsive.js', 'public/frontend/js');
mix.js('resources/assets/frontend/js/social_button.js', 'public/frontend/js');
mix.js('resources/assets/frontend/js/slide_image_photoswipe.js', 'public/frontend/js');


// pwa

var SWPrecacheWebpackPlugin = require('sw-precache-webpack-plugin');
mix.webpackConfig({
    plugins: [
        new SWPrecacheWebpackPlugin({
            cacheId: 'pwa',
            filename: 'service-worker.js',
            staticFileGlobs: ['public/frontend/css/*.css',
                'public/frontend/js/*.js',
                'public/frontend/font/**/*.{css,eot,svg,ttf,woff,woff2  }',
                'public/frontend/plugins/icon-cunghocvui/fonts/*.{eot,svg,ttf,woff,woff2}'
            ],
            minify: true,
            stripPrefix: 'public/',
            handleFetch: true,
            dynamicUrlToDependencies: { //you should add the path to your blade files here so they can be cached
                //and have full support for offline first (example below)
                // '/': ['resources/views/frontend/home/index.blade.php'],
                // '/posts': ['resources/views/posts.blade.php']
            },
            staticFileGlobsIgnorePatterns: [/\.map$/, /mix-manifest\.json$/, /manifest\.json$/, /service-worker\.js$/],
            navigateFallback: '/',
            runtimeCaching: [
                {
                    urlPattern: /^https:\/\/fonts\.googleapis\.com\//,
                    handler: 'cacheFirst'
                },
                {
                    urlPattern: /^https:\/\/www\.thecocktaildb\.com\/images\/media\/drink\/(\w+)\.jpg/,
                    handler: 'cacheFirst'
                }
            ],
            // importScripts: ['./js/push_message.js']
        })
    ]
});