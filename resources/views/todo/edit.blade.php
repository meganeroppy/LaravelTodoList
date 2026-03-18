{{-- Copyright 2026 roppy --}}
@extends('layouts.todo')

@section('title', 'タスクの編集')

@push('styles')
<style>
    .edit-container {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        max-width: 600px;
        margin: 20px auto;
    }
    .form-group {
        margin-bottom: 20px;
    }
    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #555;
    }
    input[type="text"], select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
    }
    .button-group {
        display: flex;
        gap: 10px;
        margin-top: 30px;
    }
    .save-btn {
        flex: 1;
        padding: 12px;
        background-color: #ff85a1;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
    }
    .cancel-btn {
        flex: 1;
        padding: 12px;
        background-color: #95a5a6;
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
    }
    .save-btn:hover { background-color: #ff6b8e; }
    .cancel-btn:hover { background-color: #7f8c8d; }
    .error-msg { color: #ff85a1; font-size: 0.85rem; margin-top: 5px; }
</style>
@endpush

@section('content')
<div class="edit-container">
    <h2>タスクの編集</h2>
    <form action="/todo/{{ $todo->id }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">タイトル</label>
            <input type="text" name="title" id="title" value="{{ old('title', $todo->title) }}" required>
            @error('title')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="category_id">カテゴリー</label>
            <select name="category_id" id="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $todo->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        <div class="button-group">
            <a href="/todo" class="cancel-btn">キャンセル</a>
            <button type="submit" class="save-btn">保存する</button>
        </div>
    </form>
</div>
@endsection
