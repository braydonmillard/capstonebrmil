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

Auth::routes();

Route::post('follow/{user}', [App\Http\Controllers\FollowsController::class, 'store']);

//Route::post('follow/{user}', 'FollowsController@store');

//Route::post('/follow/{user}', function(){
//    return ['success'];
//});

Route::get('/', [App\Http\Controllers\PostsController::class, 'index']);
Route::get('/p/create', [App\Http\Controllers\PostsController::class, 'create']);
Route::post('/p', [App\Http\Controllers\PostsController::class, 'store']);
Route::get('/show/{post}', [App\Http\Controllers\PostsController::class, 'show']);

Route::get('/search', [App\Http\Controllers\PostsController::class, 'search']);
Route::get('/search/{query}/sort', [App\Http\Controllers\PostsController::class, 'sort']);

Route::get('/feature/{post}', [App\Http\Controllers\PostsController::class, 'feature']);

Route::get('/rate/{post}', [App\Http\Controllers\PostsController::class, 'rate']);

Route::post('favourite/{post}', [App\Http\Controllers\PostsController::class, 'favouritePost']);
Route::post('unfavourite/{post}', [App\Http\Controllers\PostsController::class, 'unFavouritePost']);

Route::get('my_favourites', [App\Http\Controllers\UsersController::class, 'myFavourites']);

Route::get('/profile/{user}', [App\Http\Controllers\ProfilesController::class, 'index'])->name('profile.show');
Route::get('/profile/{user}/edit', [App\Http\Controllers\ProfilesController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/{user}', [App\Http\Controllers\ProfilesController::class, 'update'])->name('profile.update');
