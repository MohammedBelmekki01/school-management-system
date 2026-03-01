<?php

use Illuminate\Http\Request;

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

/*
|--------------------------------------------------------------------------
| Public API Endpoints
|--------------------------------------------------------------------------
| These routes are accessible without authentication.
| Used by the frontend website and external integrations.
*/

Route::prefix('v1')->namespace('Api')->group(function () {

    // System status
    Route::get('/status', function () {
        return response()->json([
            'success' => true,
            'message' => 'School Management System API is running.',
            'version' => '1.0.0',
            'timestamp' => now()->toIso8601String(),
        ]);
    });

    // Student public lookup (by registration number)
    Route::get('/students/lookup/{regiNo}', 'StudentApiController@lookup');

    // Public exam results
    Route::get('/results/{examId}/class/{classId}', 'StudentApiController@examResults');
});

/*
|--------------------------------------------------------------------------
| Authenticated API Endpoints
|--------------------------------------------------------------------------
| These routes require a valid API token / authentication.
*/
Route::prefix('v1')->namespace('Api')->middleware('auth:api')->group(function () {

    // Authenticated user info
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data'    => $request->user()->only(['id', 'name', 'username', 'email']),
        ]);
    });

    // Student CRUD
    Route::get('/students', 'StudentApiController@index');
    Route::get('/students/{id}', 'StudentApiController@show');

    // Class list
    Route::get('/classes', 'StudentApiController@classes');
});
