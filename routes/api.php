<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UsersVKController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
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

Route::group(['prefix' => 'toxicity', 'middleware' => 'auth.jwt','as' => 'toxicity.'], function () {
    Route::resource('users', UsersController::class)->except(['edit']);
    Route::resource('comments', CommentsController::class)->except(['edit']);
    Route::resource('posts', PostsController::class)->except(['edit']);
    Route::resource('users_vk', UsersVKController::class)->except(['edit']);
    Route::resource('groups', GroupsController::class)->except(['edit']);

    Route::get('comments/{post_id}/{user_id}', [CommentsController::class, 'get_comment']);
    Route::get('answers/{comment_id}/{user_id}', [CommentsController::class, 'get_answer']);
});

Route::post("login", [AuthController::class, 'login']);
Route::post("register", [AuthController::class, 'register']);

Route::group(["middleware" => "auth.jwt"], function() {
    route::get("logout", "App\Http\Controllers\AuthController@logout");
});
