<?php

use App\Http\Controllers\RedirectController;
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
    return view('welcome');
});

Route::view('{any}', 'app')->where('any', '.*');

Route::get('/r/{hash}', [RedirectController::class, 'redirectView']);
Route::get('get-link/{hash}', [RedirectController::class, 'getOriginalLink'])->name('link.get');
