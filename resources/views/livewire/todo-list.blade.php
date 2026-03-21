<div wire:poll.5s>
    {{-- 入力フォーム --}}
    <div style="margin-bottom: 30px; text-align: center;">
        <form wire:submit.prevent="addTodo">
            <input 
                type="text" 
                wire:model="title" 
                placeholder="タスクを入力..." 
                style="padding: 10px; width: 250px; border: 1px solid #ddd; border-radius: 4px;"
            >
            <select 
                wire:model="category_id" 
                style="padding: 10px; border: 1px solid #ddd; border-radius: 4px;"
            >
                <option value="">カテゴリーを選択</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <button 
                type="submit" 
                wire:loading.attr="disabled"
                style="padding: 10px 20px; background: #ff85a1; color: white; border: none; border-radius: 4px; cursor: pointer;"
            >
                <span wire:loading.remove>追加</span>
                <span wire:loading>...</span>
            </button>
            @error('title') <div style="color: #ff85a1; font-size: 0.8rem; margin-top: 5px;">{{ $message }}</div> @enderror
            @error('category_id') <div style="color: #ff85a1; font-size: 0.8rem; margin-top: 5px;">{{ $message }}</div> @enderror
        </form>
    </div>

    {{-- 一括削除ボタン --}}
    @if ($todos->where('is_done', true)->isNotEmpty())
        <div style="text-align: right; margin-bottom: 20px;">
            <button 
                wire:click="deleteCompleted" 
                wire:confirm="完了済みのタスクをすべて削除してもよろしいですか？"
                wire:loading.attr="disabled"
                class="delete-completed-btn"
            >
                <span wire:loading.remove wire:target="deleteCompleted">完了済みをすべて削除</span>
                <span wire:loading wire:target="deleteCompleted">削除中...</span>
            </button>
        </div>
    @endif

    {{-- ToDoの一覧 --}}
    @if ($todos->isEmpty())
        <p class="empty">タスクはまだありません。</p>
    @else
        <ul style="list-style: none; padding: 0;">
            @foreach ($todos as $todo)
                <li wire:key="todo-{{ $todo->id }}" style="background: white; margin-bottom: 10px; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <input 
                            type="checkbox" 
                            wire:click="toggle({{ $todo->id }})" 
                            {{ $todo->is_done ? 'checked' : '' }}
                            wire:loading.attr="disabled"
                            style="cursor: pointer; width: 18px; height: 18px;"
                        >
                        <span style="{{ $todo->is_done ? 'text-decoration: line-through; color: #aaa;' : '' }}">
                            {{ $todo->title }}
                        </span>
                        @if($todo)
                            <span style="font-size: 11px; background: #eee; padding: 2px 8px; border-radius: 10px; color: #666;">
                                {{ $todo->category->name ?? '未設定' }}
                            </span>
                        @endif
                    </div>
                    <div class="todo-actions" wire:key="actions-{{ $todo->id }}">
                        <a href="/todo/{{ $todo->id }}/edit" class="edit-btn">編集</a>
                        <button 
                            wire:click="delete({{ $todo->id }})" 
                            wire:confirm="削除してもよろしいですか？"
                            wire:loading.attr="disabled"
                            class="delete-btn"
                        >
                            削除
                        </button>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

    <style>
        [wire:loading] { display: none; }
        .todo-actions { display: flex; gap: 8px; }
        .edit-btn { text-decoration: none; background-color: #3498db; color: white; padding: 5px 12px; border-radius: 4px; font-size: 13px; }
        .edit-btn:hover { background-color: #2980b9; }
        .delete-btn { background-color: #f3f3f3; color: #666; border: 1px solid #ddd; padding: 4px 12px; border-radius: 4px; font-size: 13px; cursor: pointer; }
        .delete-btn:hover { background-color: #e2e2e2; }
        .delete-completed-btn { background-color: #f39c12; color: white; padding: 8px 16px; border: none; border-radius: 4px; font-size: 14px; cursor: pointer; transition: background 0.3s; }
        .delete-completed-btn:hover { background-color: #e67e22; }
        .empty { color: #aaa; text-align: center; margin-top: 40px; }
    </style>
</div>
