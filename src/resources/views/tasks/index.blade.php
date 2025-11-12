{{-- resources/views/tasks/index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('タスク一覧') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-medium text-gray-900 mb-4">あなたのタスク ({{ $tasks->count() }}件)</h3>

                    {{-- 新規作成ボタン --}}
                    <div class="mb-4">
                        <a href="{{ route('tasks.create') }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            新しいタスクを作成
                        </a>
                    </div>

                    {{-- タスクリストの表示 --}}
                    @if ($tasks->isEmpty())
                        <p class="text-gray-500">現在、タスクはありません。</p>
                    @else
                        <ul>
                            @foreach ($tasks as $task)
                                <li class="p-4 border-b flex justify-between items-center">
                                    {{-- タスク名 (完了済みの場合は取り消し線) --}}
                                    <span class="{{ $task->is_completed ? 'line-through text-gray-500' : '' }}">
                                        {{ $task->title }}
                                    </span>

                                    {{-- アクションボタン --}}
                                    <div class="flex space-x-2">
                                        <a href="{{ route('tasks.edit', $task) }}" class="text-indigo-600 hover:text-indigo-900">編集</a>

                                        <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('本当にこのタスクを削除しますか？');">
                                            @csrf
                                            @method('delete') {{-- ★ 必須: DELETEメソッドを指定 --}}
                                            <button type="submit" class="text-red-600 hover:text-red-900">削除</button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>