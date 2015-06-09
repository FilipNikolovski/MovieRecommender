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
Route::group(['prefix' => 'movies'], function() {

    Route::get('/search', ['uses' => 'MoviesController@getSearch']);

    Route::get('/', ['uses' => 'MoviesController@index']);

    Route::get('/{id}', ['uses' => 'MoviesController@getMovie']);

    Route::get('/{id}/similar-movies', ['uses' => 'MoviesController@getSimilarMovies']);

    Route::post('/rating', ['uses' => 'MoviesController@postRating']);

    Route::post('/favorites', ['uses' => 'MoviesController@postFavorites']);

    Route::post('/watchlist', ['uses' => 'MoviesController@postWatchlist']);

    Route::get('/search', ['uses' => 'MoviesController@getSearch']);

});

Route::group(['prefix' => 'tv-shows'], function() {

    Route::get('/', ['uses' => 'TvShowsController@index']);

    Route::get('/{id}', ['uses' => 'TvShowsController@getTvShow']);

    Route::post('/rating', ['uses' => 'TvShowsController@postRating']);

});

Route::controller('/auth', 'AuthController');


Route::controller('/account', 'AccountController');

Route::controller('/', 'HomeController');
