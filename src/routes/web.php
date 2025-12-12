<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

//トップページ
Route::get('/', function () {
    return view('welcome');
});

// タスク一覧ページ
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

// タスク作成ページ
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');

// タスク保存処理（POST）
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
