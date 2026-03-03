{{-- Copyright 2026 roppy --}}
@extends('layouts.app')

@section('title', 'ToDoリスト')

@push('styles')
<style>
    /* index.blade.php 固有のスタイル */
    form.add-form { display: flex; gap: 8px; margin-bottom: 24px; }
    form.add-form input[type="text"] {
        flex: 1;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
    }
    form.add-form button {
        padding: 8px 16px;
        background: #e74c3c;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .error { color: #e74c3c; font-size: 0.85rem; margin-bottom: 12px; }
    ul { list-style: none; padding: 0; margin: 0; }
    ul li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
    ul li:last-child { border-bottom: none; }
    .delete-btn {
        background: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 4px 10px;
        cursor: pointer;
        color: #888;
    }
    .todo-item { display: flex; align-items: center; gap: 10px; }
    .todo-item input[type="checkbox"] { width: 18px; height: 18px; cursor: pointer; }
    .todo-item .title { flex: 1; }
    .todo-item.done .title { text-decoration: line-through; color: #aaa; }
    .empty { color: #aaa; }
</style>
@endpush

@section('content')
<div class="card">
    {{-- 新規追加フォーム --}}
    <form class="add-form" method="POST" action="/todo">
        @csrf
        <input type="text" name="title" placeholder="タスクを入力..." value="{{ old('title') }}">
        <button type="submit">追加</button>
    </form>

    {{-- バリデーションエラーの表示 --}}
    @error('title')
        <p class="error">{{ $message }}</p>
    @enderror

    {{-- ToDoの一覧 --}}
    @if ($todos->isEmpty())
        <p class="empty">タスクはまだありません。</p>
    @else
        <ul>
            @foreach ($todos as $todo)
                <li class="todo-item {{ $todo->is_done ? 'done' : '' }}">
                    {{-- 完了切り替えフォーム --}}
                    <form method="POST" action="/todo/{{ $todo->id }}/toggle">
                        @csrf
                        @method('PATCH')
                        <button type="submit" style="background:none;border:none;padding:0;cursor:pointer;">
                            <input type="checkbox"
                                   {{ $todo->is_done ? 'checked' : '' }}
                                   onclick="this.closest('form').submit()"
                                   style="pointer-events:auto;">
                        </button>
                    </form>
                    <span class="title">{{ $todo->title }}</span>
                    {{-- 削除フォーム --}}
                    <form method="POST" action="/todo/{{ $todo->id }}">
                        @csrf
                        @method('DELETE')
                        <button class="delete-btn" type="submit">削除</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
