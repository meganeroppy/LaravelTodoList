<?php
// Copyright 2026 roppy

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * ToDoの一覧を表示する
     */
    public function index()
    {
        // DBから全てのToDoを取得して新しい順に並べる
        $todos = Todo::orderBy('created_at', 'desc')->get();

        return view('todo.index', ['todos' => $todos]);
    }

    /**
     * 新しいToDoをDBに保存する
     */
    public function store(Request $request)
    {
        // バリデーション：titleは必須・最大255文字
        $request->validate([
            'title' => 'required|max:255',
        ]);

        Todo::create(['title' => $request->title]);

        // 保存後は一覧ページへリダイレクト
        return redirect('/todo');
    }

    /**
     * ToDoを削除する
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect('/todo');
    }
}
