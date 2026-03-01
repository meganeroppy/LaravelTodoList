<?php
// Copyright 2026 roppy

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
        Schema::create('todos', function (Blueprint $table) {
            $table->id();                              // 主キー（自動採番）
            $table->string('title');                   // タスクのタイトル
            $table->boolean('is_done')->default(false); // 完了フラグ（デフォルト: 未完了）
            $table->timestamps();                      // created_at, updated_at を自動生成
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
