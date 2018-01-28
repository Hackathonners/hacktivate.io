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

/*
 * Authentication routes.
 */
Route::get('login/github', 'Auth\GithubLoginController@redirectToProvider')->name('login');
Route::get('login/github/callback', 'Auth\GithubLoginController@handleProviderCallback');
Route::post('logout', 'Auth\GithubLoginController@logout')->name('logout');

/*
 * Users routes.
 */
Route::get('/profile/edit', 'UsersController@edit')->name('users.edit');
Route::get('/profile', 'UsersController@show')->name('home');
Route::put('/profile', 'UsersController@update')->name('users.update');
Route::patch('/profile', 'UsersController@update')->name('users.update');
Route::resource('users', 'UsersController')->only('index', 'show');

/*
 * Teams routes.
 */
Route::get('/teams/rankings', 'Admin\TeamsRankingsController@index')->name('teams.rankings.index');
Route::get('/teams/rankings/refresh', 'Admin\TeamsRankingsController@refresh')->name('teams.rankings.refresh');
Route::resource('teams', 'TeamsController')->only('', 'create', 'store', 'edit', 'update', 'destroy');
Route::resource('teams/{id}/members', 'TeamMembersController')->only('index', 'store', 'destroy');

/*
 * Settings routes.
 */
Route::get('/settings/edit', 'Admin\SettingsController@edit')->name('settings.edit');
Route::put('/settings', 'Admin\SettingsController@update')->name('settings.update');
Route::patch('/settings', 'Admin\SettingsController@update')->name('settings.update');
