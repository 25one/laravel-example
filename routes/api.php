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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/verified/{api_token}', [App\Http\Controllers\Auth\RegisterController::class, 'emailVerification'])->name('verified');

Route::middleware(['auth:api', 'keyreceived'])->group(function () {
    Route::post('/widget-chat-question', [App\Http\Controllers\ApiController::class, 'widgetChatQuestion']);
    Route::post('/prompt-execute', [App\Http\Controllers\ApiController::class, 'apiPromptExecute']);
});
