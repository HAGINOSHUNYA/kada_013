<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoalController;//goalコントローラー
use App\Http\Controllers\TodoController;//todoコントローラ
use App\Http\Controllers\TagController;//tagコントローラ
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
/*
Route::get('/', function () {
    return view('welcome');
});  デフォルトのトップ画面のルート
*/
Route::get('/', [GoalController::class, 'index'])->middleware('auth');//トップページのルート


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//

Route::resource('goals', GoalController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('auth');
//goal(目標)用の各アクションのルーティングを一括で設定

Route::resource('goals.todos', TodoController::class)->only(['store', 'update', 'destroy'])->middleware('auth');
//TODO用の各アクション　TODOとGOALのモデルのインスタンスを渡す

Route::resource('tags', TagController::class)->only(['store', 'update', 'destroy'])->middleware('auth');
//tag用の各アクション　
