<?php

use Illuminate\Support\Facades\Route;

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

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
   if(Auth::check()){
      return redirect()->route('choose-room');
   }
   return view('login');
})->name('home');

Route::post('/login', 'AuthController@login')->name('login');
Route::post('/register', 'AuthController@register')->name('register');
Route::get('/logout', 'AuthController@logout')->name('logout');
Route::get('/login-social/{social}', 'SocialController@redirect')->name('login-social');
Route::get('/login-social/callback/{social}', 'SocialController@callback')->name('login-social-callback');

Route::middleware(['auth'])->group(function() {
   Route::get('/choose-room', 'ChatController@chooseRoom')->name('choose-room');
   Route::get('/create-roomid', 'ChatController@createRoomID');
   Route::post('/create-room', 'ChatController@createRoom')->name('create-room');
   Route::get('/chat', 'ChatController@chat')->name('chat');
   Route::get('/messenger/{room}', 'ChatController@startChat')->name('messenger');
   Route::get('/profile', 'ChatController@viewProfile')->name('profile');
   Route::post('/upload', 'ChatController@upload')->name('upload');
   Route::get('/save-room', 'ChatController@saveRoom')->name('save-room');
});