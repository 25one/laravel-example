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

Route::get('/', function () {
    return redirect(route('home'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    //Route::get('/', function () {
    //    return redirect(route('list-projects'));
    //});

    Route::get('/linkemailverification/{again}', [App\Http\Controllers\Auth\RegisterController::class, 'sendLinkEmailVerification'])->name('linkemailverification');

    Route::get('/link-change-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'linkChangePassword'])->name('link-change-password');
    Route::post('/change-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'changePassword'])->name('change-password');

    Route::post('/remove-account', [App\Http\Controllers\UserController::class, 'removeAccount'])->name('remove-account');    

    Route::middleware('verified')->group(function () {
        Route::get('/list-projects', [App\Http\Controllers\DashboardController::class, 'listProjects'])->name('list-projects');
        Route::resource('projects', 'App\Http\Controllers\ProjectController');
        
        Route::get('/project/{idProject}/list-prompts', [App\Http\Controllers\DashboardController::class, 'listPrompts'])->name('list-prompts');
        Route::resource('prompts', 'App\Http\Controllers\PromptController');
        Route::post('/change-active-prompt', [App\Http\Controllers\PromptController::class, 'changeActivePrompt'])->name('change-active-prompt');
        Route::post('/execute-prompt', [App\Http\Controllers\PromptController::class, 'executePrompt'])->name('execute-prompt');    

        Route::get('/description', [App\Http\Controllers\DashboardController::class, 'description'])->name('description');
        Route::resource('descriptions', 'App\Http\Controllers\DescriptionController');

        Route::get('/api-settings', [App\Http\Controllers\DashboardController::class, 'apiSettings'])->name('api-settings');
    });

    Route::get('/404', [App\Http\Controllers\DashboardController::class, 'view404'])->name('404');
});

Route::middleware('admin')->group(function () {
    Route::get('/settings', [App\Http\Controllers\DashboardController::class, 'settings'])->name('settings');
    Route::post('/make-settings', [App\Http\Controllers\DashboardController::class, 'makeSettings'])->name('make-settings');
});
