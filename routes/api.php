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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', 'Api\PassportController@login');
Route::post('register', 'Api\PassportController@register');

Route::group(['middleware' => 'auth:api'], function(){
Route::post('get-details', 'Api\PassportController@getDetails');
});

Route::post('process','Api\ControllerUrl@process');
Route::post('tools/phpca','Api\ControllerTool@toolphpca');
Route::post('tools/phpcs','Api\ControllerTool@toolPhpCs');
Route::post('tools/phpmetrics','Api\ControllerTool@toolPhpMetrics');
Route::post('tools/testability','Api\ControllerTool@testability');
Route::post('mailsending','Api\ControllerMail@sendEmail');
