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
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/formations', 'TrainingController@index')->name('training.index');
Route::get('/formations/ajouter', 'TrainingController@create')->name('training.create');
Route::post('/formations/ajouter', 'TrainingController@store')->name('training.store');
Route::post('/formations/ajouter-utilisateur-{training_id}-{user_id}', 'TrainingController@addUser')->name('training.addUser');
