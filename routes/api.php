<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/profiles', \App\Http\Controllers\ApplicationController::class)->scoped([
    'profile' => 'code'
])->except('destroy');

Route::apiResource('/experiences', \App\Http\Controllers\WorkSummaryController::class)->scoped([
    'experience' => 'code'
])->only(['show', 'update']);

Route::post('/employments/{code}', [\App\Http\Controllers\WorkHistoryController::class, 'store'])
    ->name('employments.store');
Route::apiResource('/employments', \App\Http\Controllers\WorkHistoryController::class)->scoped([
    'employment' => 'code'
])->only(['show', 'destroy']);
