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

Route::get('/mentors', function () {
    $mentors = [
        [
            'name' => 'Rui Ribeiro',
            'position' => 'SysAdmin',
            'company' => 'HASLab, INESC TEC',
            'image' => 'rribeiro',
            'description' => 'Rui Miguel is a freelance software developer and self taught sysadmin who prefers backend development because forms are boring.
Currently collaborating with HaSLab in a weird mix of researcher/sysadmin in the quest of creating tools and infrastructure to optimize everyday tasks via automation and integration.
He no longer uses free time to keep working, instead, enjoys the outdoors and tries to wake up the long lost creative side.',
        ],
        [
            'name' => 'Hugo Matalonga',
            'position' => 'Freelancer Full-stack Developer',
            'company' => '',
            'image' => 'hmatalonga',
            'description' => 'Hugo Matalonga is a freelancer Full-Stack Developer working for over 6+ years. Most of his late work concerns developing scalable progressive web applications.
From very young age, he discovered the passion for programming and kept doing it ever since.
He has a Bachelor’s degree in Computer Engineering at the University of Beira Interior.
He is a huge enthusiastic of all things open-source and always eager to learn more news topics and technologies as much as he can.
Besides his freelance work, he also has been part of a research project in Green Computing for the last year. Recently he has started getting into Machine Learning.',
        ],
        [
            'name' => 'Nuno Machado',
            'position' => 'Senior Researcher',
            'company' => 'HASLab',
            'image' => 'nmachado',
            'description' => 'Nuno Machado is a senior researcher at HASLab (INESC TEC & University of Minho), working to make large-scale distributed systems more efficient and reliable. He is convinced that one can only win the arms race against software bugs by building practical automated tools on top of sound theoretical foundations. This quest led him to do a Ph.D. in Computer Science at Instituto Superior Técnico and an internship at Microsoft Research in Redmond, during which he developed techniques to debug concurrency bugs. 
Nuno also believes that software can and should be fun. For that reason, he has participated in several programming contests, having won the 1st prize at Microsoft Imagine Cup in 2010.',
        ],
    ];

    return view('pages.mentors', compact('mentors'));
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
Route::resource('teams', 'TeamsController')->only('create', 'store', 'edit', 'update', 'destroy');
Route::resource('teams/{id}/members', 'TeamMembersController')->only('index', 'store', 'destroy');

/*
 * Settings routes.
 */
Route::get('/settings/edit', 'Admin\SettingsController@edit')->name('settings.edit');
Route::put('/settings', 'Admin\SettingsController@update')->name('settings.update');
Route::patch('/settings', 'Admin\SettingsController@update')->name('settings.update');
