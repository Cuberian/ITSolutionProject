<?php

use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\AnalysisRequestsController;
use App\Http\Controllers\AuthController;
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

Route::post('/get_jwt', [AuthController::class, 'getJWT']);
Route::post('/test', [AuthController::class, 'testRequest']);

Route::middleware('auth:api')->get('/check_jwt', [AuthController::class, 'checkJWT']);

Route::group(['prefix' => 'toxicity', 'middleware' => 'auth:api','as' => 'toxicity.'], function () {
    Route::resource('comments', CommentsController::class)->except(['edit']);
    Route::resource('posts', PostsController::class)->except(['edit']);
    Route::resource('users_vk', UsersVKController::class)->except(['edit']);
    Route::resource('groups', GroupsController::class)->except(['edit']);

    Route::get('users_vk/{user_id}/posts', [UsersVKController::class, 'get_posts']);

    Route::get('comments/{post_id}/{user_id}', [CommentsController::class, 'get_comment']);
    Route::get('answers/{comment_id}/{user_id}', [CommentsController::class, 'get_answer']);

    Route::get('analysis-requests/{user_id}', [AnalysisRequestsController::class, 'getAll']);
    Route::get('analysis-request/{req_id}', [AnalysisRequestsController::class, 'getOne']);

    Route::post('analysis/request', [AnalysisController::class, 'addToAnalysisQuery']);
});
