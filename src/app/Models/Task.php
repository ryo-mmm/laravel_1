<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    /**
     * マスアサインメントを許可するカラムを定義
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'is_completed',
        'due_date',
    ];

    /**
     * タスクを所有するユーザーを取得するリレーションを定義
     */
    public function user(): BelongsTo
    {
        // 外部キー user_id を使って User モデルと関連付ける
        return $this->belongsTo(User::class);
    }
}
