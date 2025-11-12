<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ★ 認証済みのユーザーのみアクセス可能なルートをグループ化
Route::middleware('auth')->group(function () {

    // プロフィール関連のルート
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ★ 修正: タスク管理のリソースルーティングを認証グループ内に移動
    Route::resource('tasks', TaskController::class);
});

require __DIR__.'/auth.php';