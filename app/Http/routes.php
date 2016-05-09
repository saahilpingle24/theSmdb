<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });





Route::get('/', 'HomeController@index');

Route::auth();

Route::get('/user/{id}/follow', 'ProfileController@follow')->name('user.follow');
Route::get('/user/{id}/unfollow', 'ProfileController@unfollow')->name('user.unfollow');

Route::post('/comment','CommentController@store')->name('store.comment');
Route::post('/collection/movie', 'CollectionMovieController@store')->name('movie.to.collection');


Route::get('/query/{query?}', 'SearchController@query');
Route::post('/query/navigate', 'SearchController@show')->name('redirect.profile');
Route::post('/movie/navigate', 'SearchController@movie')->name('redirect.movie');
Route::get('/movie/surprise', 'MovieController@surprise')->name('redirect.surprise');

Route::get('/user/{id}/following', 'ProfileController@getFollowing')->name('user.following');
Route::get('/user/{id}/followers', 'ProfileController@getFollowers')->name('user.followers');

Route::resource('profile', 'ProfileController');
Route::resource('collection', 'CollectionController');
Route::resource('movie', 'MovieController');






