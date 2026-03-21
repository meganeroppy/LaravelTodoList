<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel ToDo</title>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f4f7f6; margin: 0; color: #333; }
        header { background: #e74c3c; color: white; padding: 1rem; margin-bottom: 2rem; }
        .header-content { display: flex; justify-content: space-between; align-items: center; max-width: 800px; margin: 0 auto; }
        .header-content h1 { margin: 0; font-size: 1.5rem; }
        .user-info { display: flex; align-items: center; gap: 1rem; font-size: 0.9rem; }
        .logout-btn { background: rgba(255,255,255,0.2); color: white; border: 1px solid white; padding: 4px 12px; border-radius: 4px; cursor: pointer; font-size: 0.8rem; }
        .logout-btn:hover { background: white; color: #e74c3c; }
        .container { max-width: 800px; margin: 0 auto; padding: 0 20px; }
        @stack('styles')
        @livewireStyles
    </style>
</head>
<body>
@if(config('app.env') === 'staging')
    <div style="background-color: #fef3c7; color: #92400e; padding: 0.5rem; text-align: center; border-bottom: 1px solid #fcd34d; font-size: 0.875rem; font-weight: 500; position: relative; z-index: 1000;">
        🚀【検証環境 / STAGING】これはテスト用サイトです。本番データには影響しません。
    </div>
@endif

    <header>
        <div class="header-content">
            <h1>Laravel ToDo</h1>
            @auth
                <div class="user-info">
                    <span>{{ Auth::user()->name }} さん</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">ログアウト</button>
                    </form>
                </div>
            @endauth
        </div>
    </header>

    <div class="container">
        @yield('content')
    </div>

    @stack('scripts')
    @livewireScripts
</body>
</html>
