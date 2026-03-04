<?php
// Copyright 2026 roppy

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    // 一括代入を許可するカラムを指定（セキュリティ対策）
    protected $fillable = [
        'title',
        'is_done',
        'category_id',
    ];

    /**
     * このToDoが属するカテゴリーを取得
     */
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
