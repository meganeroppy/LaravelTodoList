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
        $todos = Todo::with('category')->get();
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

        Todo::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
        ]);

        // 保存後は一覧ページへリダイレクト
        return redirect('/todo');
    }

    /**
     * ToDoの完了状態を切り替える
     */
    public function toggle(Todo $todo)
    {
        // is_done を反転させる（true→false、false→true）
        $todo->update(['is_done' => !$todo->is_done]);
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
