{{-- Copyright 2026 roppy --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- 各ページでタイトルを差し込めるようにする（デフォルトはToDoアプリ） --}}
    <title>@yield('title', 'ToDoアプリ')</title>
    <style>
        body {
            font-family: sans-serif;
            background: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
        }
        /* 共通ヘッダー（ナビゲーションバー） */
        header {
            background: #e74c3c;
            color: #fff;
            padding: 15px 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        header h1 {
            margin: 0;
            font-size: 1.5rem;
        }
        /* 全ページのメインコンテンツを囲むコンテナ */
        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .card {
            background: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
    </style>
    {{-- 各ページ固有のCSSを差し込める場所 --}}
    @stack('styles')
</head>
<body>
    <header>
        <h1>Laravel ToDo</h1>
    </header>

    <main class="container">
        {{-- ここに各ページの中身（コンテンツ）が差し込まれる --}}
        @yield('content')
    </main>
</body>
</html>
