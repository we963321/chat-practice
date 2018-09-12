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
use App\Events\Chat;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::post('/sendMessage', function () {

    $name = Auth::user();
    $message = request()->get('message');

    event(new Chat($name, $message));

    return ['status' => 'OK', 'data' => ['name' => $name, 'message' => $message]];
});
