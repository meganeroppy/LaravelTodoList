<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Todo;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class TodoList extends Component
{
    public $title = '';
    public $category_id = '';

    protected $rules = [
        'title' => 'required|max:255',
        'category_id' => 'required|exists:categories,id',
    ];

    public function addTodo()
    {
        $this->validate();

        Auth::user()->todos()->create([
            'title' => $this->title,
            'category_id' => $this->category_id,
            'is_done' => false,
        ]);

        $this->title = '';
    }

    public function toggle($todoId)
    {
        $todo = Auth::user()->todos()->findOrFail($todoId);
        $todo->is_done = !$todo->is_done;
        $todo->save();
    }

    public function delete($todoId)
    {
        $todo = Auth::user()->todos()->findOrFail($todoId);
        $todo->delete();
    }

    public function deleteCompleted()
    {
        Auth::user()->todos()->where('is_done', true)->delete();
    }

    public function render()
    {
        return view('livewire.todo-list', [
            'todos' => Auth::user()->todos()->with('category')->latest()->get(),
            'categories' => Category::all(),
        ]);
    }
}
