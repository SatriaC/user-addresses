<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

Route::group(['middleware' => 'auth:api'], function () {

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/{id}', [UserController::class, 'show'])->name('users.show');
        Route::post('/add', [UserController::class, 'store'])->name('users.store');
        Route::get('/{id}/nearest', [UserController::class, 'findNearestLocation'])->name('users.nearest');
        Route::post('/{id}/update', [UserController::class, 'update'])->name('users.update');
        Route::post('/{id}/delete', [UserController::class, 'destroy'])->name('users.delete');
    });

    Route::group(['prefix' => 'address'], function () {
        Route::get('/', [AddressController::class, 'index'])->name('address.index');
        Route::get('/{id}', [AddressController::class, 'show'])->name('address.show');
        Route::post('/add', [AddressController::class, 'store'])->name('address.store');
        Route::post('/{id}/update', [AddressController::class, 'update'])->name('address.update');
        Route::post('/{id}/default', [AddressController::class, 'setDefault'])->name('address.set.default');
        Route::post('/{id}/approved', [AddressController::class, 'deleteApproved'])->name('address.delete.approved');
        Route::post('/{id}/update', [AddressController::class, 'update'])->name('address.update');
        Route::post('/{id}/delete', [AddressController::class, 'destroy'])->name('address.delete');
    });
});
