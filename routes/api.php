<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//$api = app('Dingo\Api\Routing\Router');
//
//$api->version('v1', function ($api) {
//    $api->get('category/type/{type}', [
//        'as' => 'api.category.type',
//        'uses' => 'App\Controllers\Api\CategoryController@index'
//    ]);
//});



Route::group(['prefix' => 'v1', 'middleware' => ['auth:api'], 'namespace' => 'V1'], function(){
    //Categories
    Route::get('category/type', [
        'as' => 'api.category.type',
        'uses' => 'CategoryController@getClass'
    ]);

    Route::get('category/subject', [
        'as' => 'api.category.subject',
        'uses' => 'CategoryController@getSubject'
    ]);

    Route::get('category/lesson', [
        'as' => 'api.category.lesson',
        'uses' => 'CategoryController@getLesson'
    ]);

    Route::get('category/post', [
        'as' => 'api.category.post',
        'uses' => 'CategoryController@getPost'
    ]);

    //Posts
    Route::get('category/detailpost', [
        'as' => 'api.post.detail',
        'uses' => 'PostController@getPost'
    ]);

    Route::get('search', [
        'as' => 'api.post.search',
        'uses' => 'PostController@findPost'
    ]);

    //Search History
    Route::get('history', [
        'as' => 'api.history.search',
        'uses' => 'SearchHistoryController@search'
    ]);

    Route::post('history', [
        'as' => 'api.history.delete',
        'uses' => 'SearchHistoryController@delete'
    ]);

    //Report
    Route::get('report/default', [
        'as' => 'api.report.default',
        'uses' => 'ReportController@default'
    ]);

    Route::post('report', [
        'as' => 'api.report.post',
        'uses' => 'ReportController@postReport'
    ]);

    //Offline
    Route::post('offline/posts', [
        'as' => 'api.offline.post',
        'uses' => 'OfflineController@postOffline'
    ]);

    Route::get('offline/posts', [
        'as' => 'api.offline.get',
        'uses' => 'OfflineController@getOfflinePost'
    ]);

    Route::post('offline/posts/{id}', [
        'as' => 'api.offline.delete',
        'uses' => 'OfflineController@deleteOffline'
    ]);

    //Multipart
    Route::post('multipart', [
        'as' => 'api.multipart',
        'uses' => 'MultipartController@postMedia'
    ]);

    Route::post('upload/images', [
        'as' => 'api.uploadImage',
        'uses' => 'MultipartController@uploadImage'
    ]);

    //Tìm category thích hợp
    Route::post('category/find_category', [
        'as' => 'api.category.find_category',
        'uses' => 'CategoryController@find_category'
    ]);

    //Upload post
    Route::post('category/upload_post', [
        'as' => 'api.post.upload_post',
        'uses' => 'PostController@upload_post'
    ]);

     Route::post('category/update_upload_post', [
         'as' => 'api.post.update_upload_post',
         'uses' => 'PostController@update_upload_post'
     ]);

    //Upload equation
    Route::post('equation/upload_equation', [
        'as' => 'api.equation.upload_equation',
        'uses' => 'EquationController@upload_equation'
    ]);

    Route::get('equation/list', [
        'as' => 'api.equation.list',
        'uses' => 'EquationController@list'
    ]);

    //Cong thuc
    Route::get('category/formula',[
        'as'=>'api.category.formula',
        'uses'=>'FormulaController@getCategoriesFormula'
    ]);
    // Notification
    Route::post('notification/store_token',[
        'as' => 'api.notification.store_token',
        'uses' => 'NotificationController@storeTokenDevice'
    ]);
    Route::post('notification/delete_token',[
        'as' => 'api.notification.delete_token',
        'uses' => 'NotificationController@deleteTokenDevice'
    ]);
    Route::get('category/post/related_post',[
        'as' => 'api.category.post.related',
        'uses' => 'CategoryController@relatedPost'
    ]);

    //Upload Chemical
    Route::post('chemical/upload',[
        'as' => 'api.chemical.upload',
        'uses' => 'ChemicalController@upload_chemical'
    ]);

    //upload answer second
    Route::post('post_answer/upload',[
        'as' => 'api.post_answer.upload',
        'uses' => 'PostAnswerController@upload_answer'
    ]);
    // upload score university
    Route::post('university/upload_score', [
        'as' => 'api.university.upload_score',
        'uses'  => 'UniversityController@uploadScore'
    ]);
    // upload post university
    Route::post('university/upload_post', [
        'as' => 'api.university.upload_post',
        'uses'  => 'UniversityController@uploadPost'
    ]);


});

//Auth
Route::post('v1/auth/register', [
    'as' => 'api.auth.register',
    'uses' => 'V1\AuthController@register'
]);

Route::post('v1/auth/login', [
    'as' => 'api.auth.login',
    'uses' => 'V1\AuthController@authenticate'
]);

Route::get('v1/social/{provider}/login',[
   'as' => 'api.social.login',
   'uses' =>'V1\SocialLoginController@registerOrLogin'
]);

Route::get('v1/notification/app',[
   'as' => 'notification.app',
   'uses' => 'V1\NotificationController@sendNotification'
]);