<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PageController;
use App\Http\Controllers\SpellController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\GlossaryController;
use App\Http\Controllers\MonsterController;
use App\Http\Controllers\ArchetypeController;
use App\Models\Page;
use App\Models\Spell;

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
    $pc = new PageController();
    return $pc->show(Page::where('slug','welcome')->get()->first());
});

Route::get('/roll/{roll}',function($roll){
    $ezd = new ezdice\EZDice();
    $out = ['roll'=>$ezd->roll($roll), 'dice'=>$ezd->getDiceStates(), 'modifier'=>$ezd->getModifier()];
    return json_encode($out);
});

Route::get('/glossary', [GlossaryController::class, 'index']);
Route::get('/glossary/{source}/{card}', [GlossaryController::class, 'show']);
Route::get('/glossary/{card}', [GlossaryController::class, 'lookup']);

Route::get('/pages', [PageController::class, 'index']);
Route::get('/pages/create', [PageController::class, 'create'])->can('create-page');
Route::post('/pages/create', [PageController::class, 'store'])->can('create-page');
Route::get('/page/{page:slug}', [PageController::class, 'show']);
Route::get('/page/{page:slug}/edit', [PageController::class, 'edit'])->can('update-spell');
Route::patch('/page/{page:slug}/edit', [PageController::class, 'update'])->can('update-spell');
Route::delete('/page/{page:slug}', [PageController::class, 'destroy'])->can('delete-spell');

Route::get('/spells', [SpellController::class, 'index']);
Route::get('/spell/{spell}', [SpellController::class, 'show']);

Route::get('/sources', [SourceController::class, 'index']);
Route::get('/source/{source}', [SourceController::class, 'show']);

Route::get('/monsters', [MonsterController::class, 'index']);
Route::get('/monster/{monster}', [MonsterController::class, 'show']);

Route::get('/archetypes', [ArchetypeController::class, 'index']);
Route::get('/archetype/{archetype}', [ArchetypeController::class, 'show']);

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
