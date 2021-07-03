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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/r/{hash}', [RedirectController::class, 'redirectView'])->name('redirect');
Route::get('get-link/{hash}', [RedirectController::class, 'getOriginalLink'])->name('link.get');

Route::prefix('batch-links')->group(function () {
    Route::get('/', [PasteController::class, 'index']);
    Route::post('/viewed/{id}', [PasteController::class, 'addViewedCount'])->name('viewedCount');
    Route::get('/{slug}', [PasteController::class, 'show'])->name('batch.show');
});

Route::resource('bookmarks', BookmarkController::class)->only(['index', 'store' ,'destroy']);

Route::view('{any}', 'app')->where('any', '.*');
