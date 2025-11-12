{{-- resources/views/tasks/create.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('新しいタスクを作成') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- フォームの開始: POSTメソッドで /tasks ルートに送信 --}}
                    <form method="POST" action="{{ route('tasks.store') }}">
                        @csrf {{-- ★ 必須: CSRFトークンによるセキュリティ対策 --}}

                        {{-- タイトル入力フィールド --}}
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('タスクタイトル (必須)')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        {{-- 詳細入力フィールド --}}
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('タスク詳細 (任意)')" />
                            {{-- textareaはx-text-inputではなく、HTMLタグを直接使用 --}}
                            <textarea id="description" name="description" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        {{-- 登録ボタン --}}
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('タスクを登録') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>