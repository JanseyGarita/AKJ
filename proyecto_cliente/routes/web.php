<?php

use Illuminate\Support\Facades\Cookie;
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

Route::get('/', function () {
    return view('home', ['active' => 'home']);
});

Route::resource('cars', 'CarsController');


Route::get('/profile', 'ProfileController@showProfile')->name('profile');
Route::delete('/profile/{id}/delete', 'ProfileController@destroy')->name('profile.destroy');

Route::get('/profile/saved', 'ProfileController@showProfileSaved')->name('profile.saved');
Route::get('/profile/posts', 'ProfileController@showProfilePosts')->name('profile.posts');

Route::post('/profile', 'ProfileController@update_user_info')->name('profile.update');
Route::post('/profile_img', 'ProfileController@update_user_img')->name('profile.img.update');
//isset($_COOKIE['user']) ? 'ProfileController@showProfile' : 'LoginController@get_login')->name('profile');

Route::get('/sell', function () {
    if (null !== Cookie::get('user')) {
        return view('sell', ['active' => 'sell']);
    } else {
        return redirect()->route('login');
    }
});

/**
 * Login
 */
Route::post('/SingUp', 'ProfileController@store')->name('user_singup');

Route::get(
    '/auth/{provider}',
    'SocialAuthController@redirectToProvider'
)->name('social.auth');

Route::get('/auth/{provider}/callback', 'SocialAuthController@handleProviderCallback');

Route::get('/login', function () {
    if (Cookie::get('user') != null) {
        return back();
    }
    return view('login');
})->name('login');

Route::post('/login', 'LoginController@login')->name('user_login');

Route::post('/add/favorite', 'FavoritesController@addFavorite')->name('addFavorite');

Route::post('/delete/favorite', 'FavoritesController@deleteFav')->name('deleteFav');

Route::post('/set/Sold', 'CarsController@setSold')->name('setSold');

Route::get('/logout', function () {
    Cookie::queue(Cookie::forget('user'));
    return redirect()->route('login');
})->name('log.out');

Route::get('/pdf/{id}', 'CarsController@carPDF')->name('descargarPDF');



Route::post('/contact/seller','CarsController@contactSeller')->name('contact-seller');