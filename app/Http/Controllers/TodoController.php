<?php
// Copyright 2026 roppy

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Category;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * ToDoの一覧を表示する
     */
    public function index()
    {
        // ログインユーザーのToDoだけを、カテゴリー情報付きで取得
        $todos = auth()->user()->todos()->with('category')->latest()->get();
        $categories = Category::all();
        return view('todo.index', compact('todos', 'categories'));
    }

    /**
     * 新しいToDoをDBに保存する
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        // ログインユーザーに紐付けて作成
        auth()->user()->todos()->create([
            'title' => $request->title,
            'category_id' => $request->category_id,
        ]);

        return redirect('/todo');
    }

    /**
     * ToDoの完了状態を切り替える
     */
    public function toggle(Todo $todo)
    {
        // 所有権チェック
        if ($todo->user_id !== auth()->id()) {
            abort(403);
        }

        $todo->update(['is_done' => !$todo->is_done]);
        return redirect('/todo');
    }

    /**
     * ToDoを削除する
     */
    public function destroy(Todo $todo)
    {
        // 所有権チェック
        if ($todo->user_id !== auth()->id()) {
            abort(403);
        }

        $todo->delete();
        return redirect('/todo');
    }
}
