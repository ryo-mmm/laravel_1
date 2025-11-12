<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ★ ログインユーザーのタスクのみを取得する
        // 認証済みのユーザーを取得し、そのユーザーに紐づく全てのタスクを最新順に取得する
        $tasks = Auth::user()->tasks()->latest()->get();

        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // フォームを表示するビューを返す
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. バリデーション (データ検証)
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // 2. データベースへの保存
        // Auth::user()からリレーションを通じてタスクを作成し、user_idを自動で設定させる
        Auth::user()->tasks()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            // 他のカラムはデフォルト値が適用される (is_completed = false)
        ]);

        // 3. 成功メッセージと共にタスク一覧へリダイレクト
        return redirect()->route('tasks.index')
                        ->with('status', 'タスクが正常に登録されました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
