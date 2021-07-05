<?php

use App\Http\Controllers\Api\LinkController;
use App\Http\Controllers\Api\PasteController;
use App\Http\Controllers\AuthController;
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/token', [AuthController::class, 'getToken']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        $d = $request->user();
        return response()->json([
            'name' => $d['name'],
            'email' => $d['email'],
        ]);
    });

    Route::get('paste/search/', [PasteController::class, 'search']);
    Route::apiResource('paste', PasteController::class)
        ->parameter('paste', 'paste:slug');

    Route::apiResource('link', LinkController::class)
        ->parameter('link', 'link:hash');
});
