<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminController;

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


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    //ADMIN ROUTES
    Route::prefix('admin')->middleware('role_or_permission:admin')->group(function () {
        Route::get('/schedules', [AdminController::class, 'indexSchedules']);
        Route::match(['put','patch'],'/schedule/{id}', [AdminController::class, 'updateSchedule']);
    });

    //EMPLOYEE ROUTES
    Route::prefix('user')->middleware('role_or_permission:employee|admin')->group(function () {
        Route::post('/create/schedule', [EmployeeController::class, 'storeSchedule']);
        Route::get('/schedules', [EmployeeController::class, 'indexSchedules']);
        Route::get('/myschedule', [EmployeeController::class, 'showSchedules']);
    });



    //AUTH ROUTES
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/me', [AuthController::class, 'me']);

});

