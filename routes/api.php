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

Route::post('login', 'API\AuthController@login');
Route::post('register', 'API\AuthController@register');


Route::middleware('auth:api')->group(function(){
    Route::get('contact/search/{q}/favourite/{fav}', 'API\ContactsController@search');
    Route::post('contact/favourite/{contact}', 'API\ContactsController@favourite');
    Route::resource('contact', 'API\ContactsController');
  });
