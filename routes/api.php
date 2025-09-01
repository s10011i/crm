<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\EntryController;


Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

// Admin routes
Route::middleware(['auth:sanctum', 'role:admin'])
    ->prefix('admin')
    ->group(
        function () {
            Route::get('users', [UserManagementController::class, 'index']);
            Route::post('users', [UserManagementController::class, 'store']);
        }
    );
// Operator routes
Route::middleware(['auth:sanctum', 'role:operator'])
    ->prefix('operator')
    ->group(
        function () {
            // get entries
            Route::get('entries', [EntryController::class, 'index']);
            // Create a new entry
            Route::post('entries', [EntryController::class, 'store']);
        }
    );
// Backoffice routes
Route::middleware(['auth:sanctum', 'role:backoffice'])
    ->prefix('backoffice')
    ->group(
        function () {
            // get entries
            Route::get('entries', [EntryController::class, 'index']);
            // update an entry
            Route::match(['put','patch'], 'entries/{entry}', [EntryController::class, 'update']);
            // get users
            Route::get('users', [UserManagementController::class, 'index']);
        }
    );
