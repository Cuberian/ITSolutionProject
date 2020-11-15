<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UsersVKController;
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

Route::group(['prefix' => 'toxicity', 'namespace' => 'App', 'as' => 'toxicity.'], function () {
    Route::resource('users', UsersController::class)->except(['edit']);
    Route::resource('comments', CommentsController::class)->except(['edit']);
    Route::resource('posts', PostsController::class)->except(['edit']);
    Route::resource('users_vk', UsersVKController::class)->except(['edit']);
    Route::resource('groups', GroupsController::class)->except(['edit']);
});

