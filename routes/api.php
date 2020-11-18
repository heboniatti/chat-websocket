<?php

use App\Events\SendMessage;
use App\Http\Controllers\Api\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

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


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('users', [UserController::class, 'index'])->name('user.index');
    Route::get('users/{user}', [UserController::class, 'show'])->name('user.show');
    Route::get('user/me', [UserController::class, 'me'])->name('user.me');
    Route::get('messages/{user}', [MessageController::class, 'listMessages'])->name('message.list');
    Route::post('messages/{user}', [MessageController::class, 'store'])->name('message.store');
});



Route::get('/oi', function () {
    Event::dispatch(new SendMessage);
});
