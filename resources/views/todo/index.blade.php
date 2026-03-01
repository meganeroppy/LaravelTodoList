{{-- Copyright 2026 roppy --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDoアプリ</title>
    <style>
        body {
            font-family: sans-serif;
            max-width: 600px;
            margin: 60px auto;
            background: #f5f5f5;
            color: #333;
        }
        .card {
            background: #fff;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h1 { margin-top: 0; color: #e74c3c; }
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
        .empty { color: #aaa; }
    </style>
</head>
<body>
    <div class="card">
        <h1>ToDo アプリ</h1>

        {{-- 新規追加フォーム --}}
        <form class="add-form" method="POST" action="/todo">
            @csrf {{-- CSRF対策トークン（LaravelのPOSTには必須） --}}
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
                    <li>
                        <span>{{ $todo->title }}</span>
                        {{-- 削除フォーム（DELETE メソッドは HTML 非対応のため @method で偽装） --}}
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
</body>
</html>
