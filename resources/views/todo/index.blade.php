{{-- Copyright 2026 roppy --}}
@extends('layouts.todo')

@section('title', 'ToDoリスト')

@push('styles')
<style>
    /* index.blade.php 固有のスタイル */
    .input-group {
        display: flex;
        gap: 10px;
    }

    input[type="text"] {
        flex: 2;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
    }

    select {
        flex: 1;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background-color: white;
        font-size: 16px;
    }

    button {
        padding: 12px 24px;
        background-color: #e74c3c;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        transition: background 0.3s;
    }

    button:hover {
        background-color: #c0392b;
    }

    .category-badge {
        background-color: #eee;
        color: #666;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 12px;
        margin-left: 10px;
    }
    form.add-form { display: flex; gap: 8px; margin-bottom: 24px; }
    /* The following styles are replaced by more general input[type="text"] and button styles */
    /*
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
    */
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
<div class="todo-container">
    <!-- タスク追加フォーム -->
    <form action="/todo" method="POST" class="add-form">
        @csrf
        <div class="input-group">
            <input type="text" name="title" placeholder="タスクを入力..." value="{{ old('title') }}">
            
            <select name="category_id">
                <option value="" disabled selected>カテゴリーを選択</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit">追加</button>
        </div>
        @error('title')
            <p class="error-msg">{{ $message }}</p>
        @enderror
        @error('category_id')
            <p class="error-msg">{{ $message }}</p>
        @enderror
    </form>

    {{-- ToDoの一覧 --}}
    @if ($todos->isEmpty())
        <p class="empty">タスクはまだありません。</p>
    @else
        <ul class="todo-list">
            @foreach ($todos as $todo)
                <li class="todo-item {{ $todo->is_done ? 'completed' : '' }}">
                    <div class="todo-left">
                        <form action="/todo/{{ $todo->id }}/toggle" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="checkbox" onChange="this.form.submit()" {{ $todo->is_done ? 'checked' : '' }}>
                        </form>
                        <span class="todo-text">{{ $todo->title }}</span>
                        <span class="category-badge">{{ $todo->category->name ?? 'なし' }}</span>
                    </div>
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
