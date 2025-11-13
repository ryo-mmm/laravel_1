<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ★ 1. ログイン/ログアウト状態でアクセス可能なルート
//    ルート / が存在しないため、ユーザーがログアウトした後にエラーになるのを防ぐ
Route::get('/', function () {
    // ユーザーがログインしている場合はタスク一覧へリダイレクト
    if (Auth::check()) {
        return redirect()->route('tasks.index');
    }
    // ログインしていない場合はログインページへ
    return redirect()->route('login');
});

// 認証済みのユーザーのみアクセス可能なルートをグループ化
Route::middleware('auth')->group(function () {

    // タスク管理のリソースルーティング (最重要)
    Route::resource('tasks', TaskController::class);

    // プロフィール関連のルート
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ★ 2. 認証ルート (Breezeのログイン、登録などのルート定義)
require __DIR__.'/auth.php';