<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

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
    public function edit(Task $task)
    {
        // ★ 注意: ステップ5で認可機能を入れるまでは、ここでユーザーチェックは行いません。

        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * * モデルバインディング: URLの {task} パラメータに基づき Task インスタンスを自動取得
     */
    public function update(Request $request, Task $task)
    {
        // 1. バリデーション
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_completed' => 'boolean', // チェックボックスの状態を受け取る
        ]);

        // 2. データの更新
        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            // is_completed が送信されていない場合は false を設定
            'is_completed' => $request->has('is_completed'),
        ]);

        // 3. 成功メッセージと共にタスク一覧へリダイレクト
        return redirect()->route('tasks.index')
                        ->with('status', 'タスクが正常に更新されました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        // 1. データの削除を実行
        $task->delete();

        // 2. 成功メッセージと共にタスク一覧へリダイレクト
        return redirect()->route('tasks.index')
                        ->with('status', 'タスクが正常に削除されました。');
    }
}
