<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // 外部キー: どのユーザーがタスクを作成したかを示す
            // constrained() で users テーブルへの参照を自動設定
            // cascadeOnDelete() でユーザー削除時にタスクも自動削除
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // タスクのタイトル（必須）
            $table->string('title', 255);

            // タスクの詳細（長文、任意）
            $table->text('description')->nullable();

            // タスクの状態 (完了/未完了、デフォルトは未完了=false)
            $table->boolean('is_completed')->default(false);

            // 期限日（任意）
            $table->timestamp('due_date')->nullable();

            // created_at, updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
