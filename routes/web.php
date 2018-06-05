<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/view/{postId}', 'HomeController@viewPost')->name('view-post');

// Auth::routes();
Route::group(['prefix' => 'admin'], function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/', 'Admin\AdminController@index');
        Route::get('/profile', 'Admin\UserController@index')->name('profile');
        Route::post('/change-name', 'Admin\UserController@changeName')->name('change-name');
        Route::post('/change-email', 'Admin\UserController@changeEmail')->name('change-email');
        Route::get('/article-management', 'Admin\ArticleManagementController@index')->name('article-management');
        Route::get('/category/{id}/delete', 'Admin\CategoryController@delete')->name('category-delete');
        Route::resources([
            'posts' => 'Admin\PostController',
            'category' => 'Admin\CategoryController',
        ]);
    });

    Route::get('/confirm-change-email/{token}', 'Admin\UserController@confirmChangeEmail');

    Route::group(['namespace' => 'Auth'], function () {
        // Authentication Routes...
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout')->name('logout');

        // Registration Routes...
        Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'RegisterController@register');

        // Password Reset Routes...
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'ResetPasswordController@reset');
    });
});

Route::get('/home', 'HomeController@index')->name('home');
