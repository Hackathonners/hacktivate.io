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

Route::get('/', function () {
    return view('pages.welcome');
});

Route::get('login/github', 'Auth\GithubLoginController@redirectToProvider')->name('login');
Route::get('login/github/callback', 'Auth\GithubLoginController@handleProviderCallback');
Route::post('logout', 'Auth\GithubLoginController@logout')->name('logout');

Route::get('/profile/edit', 'UsersController@edit')->name('users.edit');
Route::put('/profile', 'UsersController@update')->name('users.update');
Route::patch('/profile', 'UsersController@update')->name('users.update');

Route::middleware('auth')->group(function () {
    Route::get('/profile', 'UsersController@show')
        ->name('home');

    Route::resource('teams', 'TeamsController')
        ->only('create', 'store', 'edit', 'update', 'destroy');

    Route::resource('users', 'UsersController')
        ->only('index', 'show');

    Route::resource('teams/{id}/members', 'TeamMembersController')
        ->only('index', 'store', 'destroy');
});
