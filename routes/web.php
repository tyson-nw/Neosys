<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PageController;
use App\Http\Controllers\SpellController;

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

Route::get('/pages', [PageController::class, 'index']);
Route::get('/pages/create', [PageController::class, 'create']);
Route::post('/pages/create', [PageController::class, 'store']);
Route::get('/page/{page:slug}', [PageController::class, 'show']);
Route::get('/page/{page:slug}/edit', [PageController::class, 'edit']);
Route::patch('/page/{page:slug}/edit', [PageController::class, 'update']);
Route::delete('/page/{page:slug}', [PageController::class, 'destroy']);

Route::get('/spells', [SpellController::class, 'index']);
Route::get('/spells/create', [SpellController::class, 'create']);
Route::post('/spells/create', [SpellController::class, 'store']);
Route::get('/spell/{page:slug}', [SpellController::class, 'show']);
Route::get('/spell/{page:slug}/edit', [SpellController::class, 'edit']);
Route::patch('/spell/{page:slug}/edit', [SpellController::class, 'update']);
Route::delete('/spell/{page:slug}', [SpellController::class, 'destroy']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
