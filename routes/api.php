<?php

use Illuminate\Http\Request;

/*$year = date("Y");
$curdate = date("Y-m-d");
$startdate = date($year.'-'.Config::get('prosnowVariables.startPush'));
$stopdate = date($year.'-'.Config::get('prosnowVariables.stopPush'));
*/
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
Route::prefix('v1')->namespace('V1')->group(function () { 
    Route::prefix('auth')->namespace('Auth')->group(function () {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        //Route::post('register', 'RegisterController@register');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::post('password/reset', 'ResetPasswordController@reset')->name('password.reset');
        Route::middleware('jwt.auth')->group(function () {
            Route::get('me', 'AuthController@me');
        });
    });
    

    Route::prefix('admin')->namespace('Admin')->middleware('jwt.auth', 'admin')->group(function () {
      Route::post('import', 'ImportController@store')->name('import.store');
      Route::apiResource('users', 'UserController')->except(['index','update','destroy']);
      Route::apiResource('roles', 'RoleController')->except(['index']);
      Route::apiResource('themes', 'ThemeController')->except(['index']);
      Route::apiResource('thematics', 'ThematicController')->except(['index']);
      Route::apiResource('relationships', 'RelationshipController')->except(['index']);
    });

    Route::prefix('admin')->namespace('Admin')->middleware('jwt.auth', 'user')->group(function () {
      Route::put('users/{id}', 'UserController@update')->name('users.update');
      Route::delete('users/{id}', 'UserController@destroy')->name('users.destroy');
    });
    
    Route::middleware('jwt.auth', 'editor')->group(function () {
      Route::put('event/{id}', 'EventController@update')->name('events.update'); 
      Route::delete('event/{id}', 'EventController@destroy')->name('events.delete');
    });

    Route::middleware('jwt.auth', 'contributor')->group(function () {
      Route::get('events/list', 'EventController@list')->name('events.list');
      Route::post('event', 'EventController@store')->name('events.store');
      Route::post('upload/image','ImageController@upload')->name('images.upload');
      Route::get('images', 'ImageController@index')->name('images.index');
      Route::put('image/{id}', 'ImageController@update')->name('images.update');
      Route::delete('storage/{filename}','ImageController@destroy')->name('images.destroy');
      Route::namespace('Admin')->group(function () {
        Route::get('users', 'UserController@index')->name('users.index');
        Route::get('roles', 'RoleController@index')->name('roles.index');
        Route::get('themes', 'ThemeController@index')->name('themes.index');
      });
    });

    Route::middleware('jwt.auth', 'user')->group(function () {
      Route::put('events/update_user/{id}', 'EventController@update_user')->name('events.update_user');
    });
    
    Route::get('events', 'EventController@index')->name('events.index');
    Route::get('event/{id}', 'EventController@show')->name('events.show');
    Route::post('events/export/', 'EventController@export')->name('events.export');
    Route::post('events/geojson','EventController@geojson')->name('events.geojson');
    Route::namespace('Admin')->group(function () {
      Route::get('relationships', 'RelationshipController@index')->name('relationships.index');
      Route::get('thematics', 'ThematicController@index')->name('thematics.index');
    });
});

Route::fallback(function(){
  return response()->json(['status'=>'error','message'=>'Route not found'], 404);
});
