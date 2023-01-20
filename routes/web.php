<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PageController;
use App\Http\Controllers\SpellController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\MonsterController;
use App\Models\Spell;
use App\Models\Card;

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

Route::get('/roll/{roll}',function($roll){
    $ezd = new ezdice\EZDice();
    $out = ['roll'=>$ezd->roll($roll), 'dice'=>$ezd->getDiceStates(), 'modifier'=>$ezd->getModifier()];
    return json_encode($out);
});

Route::get('/card/{source}/{card}', [CardController::class, 'show']);
Route::get('/card/{card}', [CardController::class, 'lookup']);

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
Route::get('/spell/{spell}', [SpellController::class, 'show']);
Route::get('/spell/{spell}/edit', [SpellController::class, 'edit']);
Route::patch('/spell/{spell}/edit', [SpellController::class, 'update']);
Route::delete('/spell/{spell}', [SpellController::class, 'destroy']);

Route::get('/sources', [SourceController::class, 'index']);
Route::get('/source/{source}', [SourceController::class, 'show']);

Route::get('/monsters', [MonsterController::class, 'index']);
Route::get('/monster/{monster}', [MonsterController::class, 'show']);

Route::get('/mode', function(){
    if(empty(session('mode'))){
        session(['mode'=>'dark']);
    
    }elseif(session('mode') == 'dark'){
        session(['mode'=>'paper']);
    }elseif(session('mode') == 'paper'){
        session()->forget('mode');
    }
    return redirect(url()->previous());
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
