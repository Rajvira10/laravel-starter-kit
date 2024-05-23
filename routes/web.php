<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['namespace' => 'App\Http\Controllers'], function() {
    
    Route::view('/', 'login')->name('login')->middleware('guest');

    Route::post('authenticate', 'AuthenticationController@authenticate')->name('authenticate');

    Route::get('forgot-password', 'AuthenticationController@forgotPassword')->name('forgot_password');

    Route::post('reset-password', 'AuthenticationController@resetPassword')->name('reset_password');

    Route::get('reset-password', 'AuthenticationController@resetPasswordForm')->name('reset_password_form');

    Route::post('reset-password-update', 'AuthenticationController@resetPasswordUpdate')->name('reset_password_update');

    Route::group(['middleware' => ['auth:web']], function() {

        Route::post('logout', 'AuthenticationController@logout')->name('logout');

        Route::get('dashboard', 'DashboardController@index')->name('dashboard');

        Route::group(['prefix' => 'user'], function(){

            Route::get('index', 'UserController@index')->name('users.index');
        
            Route::get('create', 'UserController@create')->name('users.create');

            Route::post('store', 'UserController@store')->name('users.store');

            Route::get('{user_id}', 'UserController@show')->name('users.show');

            Route::get('edit/{user_id}', 'UserController@edit')->name('users.edit');

            Route::post('update/{user_id}', 'UserController@update')->name('users.update');

            Route::delete('delete', 'UserController@destroy')->name('users.destroy');

            Route::get('user-roles/{user_id}', 'UserController@userRoles')->name('users.user_roles');

            Route::post('user-roles/{user_id}', 'UserController@assignRoles')->name('users.assign_roles');
              
        });

        Route::group(['prefix' => 'menu'], function(){
                
            Route::get('index', 'MenuController@index')->name('menus.index');
        
            Route::get('create', 'MenuController@create')->name('menus.create');

            Route::post('store', 'MenuController@store')->name('menus.store');

            Route::get('edit/{menu_id}', 'MenuController@edit')->name('menus.edit');

            Route::post('update/{menu_id}', 'MenuController@update')->name('menus.update');

            Route::delete('delete', 'MenuController@destroy')->name('menus.destroy');

        });

        Route::group(['prefix' => 'role'], function(){
                
            Route::get('index', 'RoleController@index')->name('roles.index');
        
            Route::get('create', 'RoleController@create')->name('roles.create');

            Route::post('store', 'RoleController@store')->name('roles.store');

            Route::get('{role_id}', 'RoleController@show')->name('roles.show');

            Route::get('edit/{role_id}', 'RoleController@edit')->name('roles.edit');

            Route::post('update/{role_id}', 'RoleController@update')->name('roles.update');

            Route::delete('delete', 'RoleController@destroy')->name('roles.destroy');

        });

        Route::group(['prefix' => 'menu-role'], function(){
                    
            Route::get('index', 'MenuRoleController@index')->name('menu_roles.index');
        
        });

        Route::group(['prefix' => 'settings'], function(){
                    
            Route::get('index', 'SettingController@index')->name('settings.index');

            Route::post('update', 'SettingController@update')->name('settings.update');

        });
    });   
});
