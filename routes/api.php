<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UsersVKController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'toxicity', 'middleware' => 'auth.check','as' => 'toxicity.'], function () {
    Route::resource('users', UsersController::class)->except(['edit']);
    Route::resource('comments', CommentsController::class)->except(['edit']);
    Route::resource('posts', PostsController::class)->except(['edit']);
    Route::resource('users_vk', UsersVKController::class)->except(['edit']);
    Route::resource('groups', GroupsController::class)->except(['edit']);

    Route::get('comments/{post_id}/{user_id}', [CommentsController::class, 'get_comment']);
    Route::get('answers/{comment_id}/{user_id}', [CommentsController::class, 'get_answer']);
});
