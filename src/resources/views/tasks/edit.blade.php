{{-- resources/views/tasks/edit.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('タスクを編集') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- フォームの開始: PATCHメソッドで tasks.update ルートに送信 --}}
                    <form method="POST" action="{{ route('tasks.update', $task) }}">
                        @csrf
                        @method('patch') {{-- ★ 必須: PATCHメソッドを指定 --}}

                        {{-- タイトル入力フィールド --}}
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('タスクタイトル (必須)')" />
                            {{-- 既存データまたはバリデーションエラー時のold値を表示 --}}
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $task->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        {{-- 詳細入力フィールド --}}
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('タスク詳細 (任意)')" />
                            <textarea id="description" name="description" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('description', $task->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        {{-- 完了ステータスチェックボックス --}}
                        <div class="mb-6 flex items-center">
                            <input id="is_completed" name="is_completed" type="checkbox" value="1"
                                class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500"
                                {{ old('is_completed', $task->is_completed) ? 'checked' : '' }}>
                            <label for="is_completed" class="ms-2 text-sm font-medium text-gray-900">タスクを完了する</label>
                        </div>

                        {{-- 更新ボタン --}}
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('タスクを更新') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>