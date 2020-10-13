<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


// Route::group(['prefix' => 'admin'], function() {
//     Route::get('/', 'Api\BookController@index');

//     Route::get('/external-books','Api\BookController@externalBooks');

//     Route::resource('books','Api\BookController');

//     Route::get('/search','Api\BookController@search');
// });


Route::group(['prefix' => 'admin'], function() {
    Route::get('/', 'Api\TaskController@index');

    Route::resource('tasks','Api\TaskController');

    Route::get('/search','Api\TaskController@search');
});