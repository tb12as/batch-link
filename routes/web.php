<?php

use App\Http\Controllers\Front\BookmarkController;
use App\Http\Controllers\Front\PasteController;
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

Route::middleware('blademin')->group(function () {
    Route::get('/', function () {
        return view('landing');
    });

    Route::prefix('public-batch')->group(function () {
        Route::get('/', [PasteController::class, 'index'])->name('batch.index');
        Route::post('/viewed/{id}', [PasteController::class, 'addViewedCount'])->name('viewedCount');
        Route::get('/{slug}/d', [PasteController::class, 'show'])->name('batch.show');
        Route::get('/search', [PasteController::class, 'search'])->name('batch.search');
    });

    Route::resource('bookmarks', BookmarkController::class)
        ->middleware(['auth', 'verified:login'])
        ->only(['index', 'store', 'destroy']);
});

Route::get('/r/{hash}', [RedirectController::class, 'redirectView'])->name('redirect');
Route::get('get-link/{hash}', [RedirectController::class, 'getOriginalLink'])->name('link.get');

Route::view('{any}', 'app')->where('any', '.*');

// dummy
Route::get('/login', fn () => view('app'))->name('login');
Route::get('/sign-up', fn () => view('app'))->name('register');
