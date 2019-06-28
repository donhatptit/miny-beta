<?php

Route::get('/', [
    'as'   => 'frontend.home.index',
    'uses' => 'Frontend\HomeController@index'
]);

Route::get('/bai-viet/{slug}.html', [
    'as'   => 'frontend.post.detail',
    'uses' => 'Frontend\PostController@detail'
]);
Route::get('/cau-hoi/{code}-{slug}.html',[
   'as'=>'frontend.question',
   'uses'=>'Frontend\QuestionController@index'
]);
Route::get('/cau-hoi/chi-tiet/{code}-{slug}.html',[
    'as'=>'frontend.question.detail',
    'uses'=>'Frontend\QuestionController@detail'
]);
Route::post('/cau-hoi/status',[
    'as'=>'frontend.question.status',
    'uses'=>'Frontend\QuestionController@storeStatus'
]);

Route::get('/danh-muc/{slug}.html', function ($slug) {
    return redirect()->route('frontend.category.index', ['slug' => $slug]);
});
Route::get('danh-muc/phuong-trinh-hoa-hoc',[
    'as' => 'frontend.equation.index',
    'uses'=>'Frontend\EquationController@index'
]);
Route::get('phuong-trinh-hoa-hoc/{slug?}',[
    'as' => 'frontend.equation.equationDetail',
    'uses' => 'Frontend\EquationController@equationDetail'
//])->where(['slug' => ".*"]);
])->where(['slug' => "((?!chu-de).)*"]);
Route::get('phuong-trinh/',[
    'as' => 'frontend.equation.searchEquation',
    'uses' => 'Frontend\EquationController@searchEquation'
]);
Route::get('phuong-trinh-dieu-che-{symbol}',[
    'as' => 'frontend.equation.chemicalProductEquation',
    'uses' => 'Frontend\EquationController@chemicalProductEquation'
]);
Route::get('chat-tham-gia-phan-ung-{symbol}',[
    'as' => 'frontend.equation.chemicalReactantEquation',
    'uses' => 'Frontend\EquationController@chemicalReactantEquation'
]);
Route::get('chat-hoa-hoc',[
    'as'=>'frontend.equation.chemical',
    'uses'=> 'Frontend\EquationController@chemical'
]);
Route::get('chat-hoa-hoc/tim-kiem',[
    'as'=>'frontend.equation.searchChemical',
    'uses'=> 'Frontend\EquationController@searchChemical'
]);
Route::get('chat-hoa-hoc/{symbol}',[
    'as'=>'frontend.equation.chemicalDetail',
    'uses'=> 'Frontend\EquationController@chemicalDetail'
]);
Route::get('phuong-trinh-hoa-hoc/chu-de/{slug}',[
    'as' => 'frontend.equation.listEquationbyCate',
    'uses' => 'Frontend\EquationController@listEquationbyCate'
]);
Route::prefix('cong-cu-hoa-hoc')->group(function () {
    Route::get('bang-tinh-tan',[
        'as' => 'frontend.equation.dissolubilityTable',
        'uses' => 'Frontend\EquationController@dissolubilityTable'
    ]);
    Route::get('bang-tuan-hoan-nguyen-to-hoa-hoc',[
        'as' => 'frontend.equation.periodicTable',
        'uses' => 'Frontend\EquationController@periodicTable'
    ]);
    Route::get('day-dien-hoa',[
        'as' => 'frontend.equation.electrochemicalTable',
        'uses' => 'Frontend\EquationController@electrochemicalTable'
    ]);
    Route::get('day-hoat-dong-kim-loai',[
        'as' => 'frontend.equation.reactivityseriesTable',
        'uses' => 'Frontend\EquationController@reactivityseriesTable'
    ]);
});
Route::get('/danh-muc/{slug}', [
    'as'   => 'frontend.category.index',
    'uses' => 'Frontend\CategoryController@index'
]);
Route::get('/suggestequation/ajax/left','Frontend\EquationController@chemicalReactantAjax');
Route::get('/suggestequation/ajax/right','Frontend\EquationController@chemicalProductAjax');
Route::get('/suggestchemical/ajax','Frontend\EquationController@chemicalAjax');
Route::get('/tim-kiem', [
    'as'   => 'frontend.search.index',
    'uses' => 'Frontend\SearchController@index'
]);
Route::get('/timkiem/api-search', [
    'as'   => 'frontend.search.searchAutocomplete',
    'uses' => 'Frontend\SearchController@searchAutocomplete'
]);
Route::post('/admin/action/post', [
    'as'   => 'backend.action.post',
    'uses' => 'Frontend\PostController@storeStatus'
]);

Route::get('/thong-tin-tuyen-sinh-dai-hoc-cao-dang-tren-ca-nuoc', function (){
    return redirect('tuyen-sinh/thong-tin-tuyen-sinh-dai-hoc-cao-dang-tren-ca-nuoc', 301);
});
Route::get('/{slug}/thong-tin-tuyen-sinh', function ($slug){
    return redirect()->route('university.index', $slug)->setStatusCode(301);
});
/** Tuyen sinh */
Route::group(['prefix' => 'tuyen-sinh'], function () {
    Route::get('/thong-tin-tuyen-sinh-dai-hoc-cao-dang-tren-ca-nuoc', [
        'uses' => 'Frontend\AdmissionController@index',
        'as'    => 'admission.home'
    ]);
    Route::get('/{slug}/thong-tin-tuyen-sinh', [
        'uses'  => 'Frontend\UniversityController@index',
        'as'    => 'university.index'
    ]);
    Route::get('thong-tin-cac-truong-tren-ca-nuoc',[
        'as'    => 'admission.university.list',
        'uses'  => 'Frontend\AdmissionController@listUniversity'
    ]);
    Route::get('tra-cuu-diem-chuan-chinh-xac-nhat',[
        'uses'  => 'Frontend\AdmissionController@searchUniversity',
        'as'    => 'admission.university.search'
    ]);

    Route::get('tin-tuc-tuyen-sinh-day-du-nhat',[
        'as'    => 'admission.university.news',
        'uses'  => 'Frontend\AdmissionController@listNews'
    ]);
    Route::get('dinh-huong-tu-van-tuyen-sinh',[
        'as'    => 'admission.university.advice',
        'uses'  => 'Frontend\AdmissionController@advice'
    ]);
    Route::get('bai-viet/{slug}.html',[
        'as'    => 'admission.university.post',
        'uses'  => 'Frontend\AdmissionController@postDetail'
    ]);
    Route::get('tu-van-tuyen-sinh/tu-van-tuyen-sinh-nganh-{slug}',[
        'as'    =>  'adminssion.university.topic',
        'uses'  => 'Frontend\AdmissionController@newsTopic'
    ]);
    Route::get('filter-district',[
       'as'     => 'admission.university.filter_district',
       'uses'   => 'Frontend\AdmissionController@filterDistrict'
    ]);
    Route::get('load-more-topic',[
        'as'    => 'admission.load_more_topic',
        'uses'  => 'Frontend\AdmissionController@loadMoreTopic'
    ]);
// chi tiet tung truong

    Route::get('{slug}/diem-chuan',[
        'uses'  => 'Frontend\UniversityController@score',
        'as'    => 'university.score'
    ]);
    Route::get('{slug}/tin-tuc-tuyen-sinh',[
        'uses'  => 'Frontend\UniversityController@news',
        'as'    => 'university.news'
    ]);
    Route::get('{slug}/hinh-anh',[
        'uses'  => 'Frontend\UniversityController@showImage',
        'as'    => 'university.show_image'
    ]);
    Route::post('/university/storeStatus',[
        'as'=>'university.post.storeStatus',
        'uses'=>'Frontend\UniversityController@storeStatusPost'
    ]);
});




/** Intro App */
Route::get('/dieu-khoan-su-dung',function (){
    return view('frontend.home.rules');
});
Route::get('/gioi-thieu-app',function(){
    return view('frontend.home.ladipage');
});
Route::get('/gioi-thieu-cunghocvui',[
   'name' => 'fontend.home.introduct',
    'uses' => 'Frontend\IntroductController@index'
]);


/** Sitemaps */
Route::group([], function () {
    Route::get('sitemaps', ['as' => 'sitemap.all', 'uses' => 'Frontend\SitemapController@index']);
    Route::get('sitemap/{type}_{part}.xml', ['as' => 'sitemap.detail', 'uses' => 'Frontend\SitemapController@detail']);
});


/** SOCIALIZE LOGIN */
Route::group(['prefix' => 'app'], function () {
    Route::get('{provider}/login','Frontend\Auth\SocialiteAuthController@redirectToProvider');
    Route::get('{provider}/callback', 'Frontend\Auth\SocialiteAuthController@handleProviderCallback');
});


?>