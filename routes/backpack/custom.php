<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    CRUD::resource('post', 'PostCrudController');
    CRUD::resource('category', 'CategoryCrudController');
    CRUD::resource('tag','TagCrudController');
    CRUD::resource('question-category','QuestionCategoryCrudController');
    CRUD::resource('question','QuestionCrudController');
    CRUD::resource('equation', 'EquationCrudController');
    CRUD::resource('token-device', 'TokenDeviceCrudController');
    CRUD::resource('report','ReportCrudController');
    CRUD::resource('post-answer', 'PostAnswerCrudController');
    CRUD::resource('menu-item', 'MenuItemCrudController');
    CRUD::resource('kind', 'KindCrudController');
    CRUD::resource('university', 'UniversityCrudController');
    CRUD::resource('location', 'LocationCrudController');
    CRUD::resource('image', 'ImageCrudController');
    CRUD::resource('university-attribute', 'UniversityAttributeCrudController');
    CRUD::resource('topic', 'TopicCrudController');
    CRUD::resource('ts-post', 'TsPostCrudController');
    CRUD::resource('score', 'ScoreCrudController');
    CRUD::resource('guideline', 'GuidelineCrudController');

    if (config('backpack.base.setup_dashboard_routes')) {
        Route::get('dashboard', 'DashboardController@index')->name('backpack.dashboard');
        Route::get('mn-category','CategoryController@index')->name('admin.category');
        Route::post('mn-category','CategoryController@index')->name('admin.category.post');
        Route::get( 'mn-category/check_moving/{id}/{direction}',
            [ 'as' => 'backend.category.check_moving', 'uses' => 'CategoryController@checkMoving' ])
            ->where( [ 'id' => '[0-9]+', 'direction' => '(up)|(left)|(right)|(down)' ]);
        Route::get('mn-category/moving/{id}/{direction}',
            ['as' => 'backend.category.moving', 'uses' => 'CategoryController@moving'])
            ->where(['id' => '[0-9]+', 'direction' => '(up)|(left)|(right)|(down)']);
        Route::get('mn-category/delete/{id}', [
            'as' => 'backend.category.delete',
            'uses' => 'CategoryController@delete'
        ]);
        Route::get('api/category', 'CategoryController@getCategory')->name('admin.category.get');
        Route::get('api/category-question',[
           'uses'=> 'QuestionCrudController@getCategory',
            'as' => 'admin.category.question.get'
        ]);
        Route::get('api/post/ajax-category-option',[
           'as' => 'admin.post.filter.category.ajax',
           'uses' => 'PostCrudController@filterByCategory'
        ]);
        Route::get('api/post/ajax-user-option',[
           'as' => 'admin.post.filter.users.ajax',
            'uses' => 'PostCrudController@filterByUser'
        ]);
        Route::get('api/post/filter-university',[
            'as'    => 'admin.post.filter.university',
            'uses'  => 'UniversityCrudController@filterUniversity'
        ]);

    }


    // Custom Admin

    Route::get('u/token', [
       'as' => 'admin.user.token.list',
       'uses' => 'UserController@getApiToken'
    ]);

    Route::get('u/token/{id}', [
        'as' => 'admin.user.token.gen',
        'uses' => 'UserController@genApiToken'
    ]);

    Route::get('guideline-detail/{id}', [
        'as' => 'admin.guide.detail',
        'uses' => 'GuidelineCrudController@show'
    ]);
    CRUD::resource('demoposts', 'DemopostsCrudController');
});