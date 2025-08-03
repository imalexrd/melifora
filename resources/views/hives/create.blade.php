<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Hive') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('hives.store') }}">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name">{{ __('Name') }}</label>
                            <input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        </div>

                        <!-- Apiary ID -->
                        <div class="mt-4">
                            <label for="apiary_id">{{ __('Apiary ID') }}</label>
                            <input id="apiary_id" class="block mt-1 w-full" type="text" name="apiary_id" :value="old('apiary_id')" required />
                        </div>

                        <!-- Slug -->
                        <div class="mt-4">
                            <label for="slug">{{ __('Slug') }}</label>
                            <input id="slug" class="block mt-1 w-full" type="text" name="slug" :value="old('slug')" required />
                        </div>

                        <!-- Type -->
                        <div class="mt-4">
                            <label for="type">{{ __('Type') }}</label>
                            <select id="type" name="type" class="block mt-1 w-full">
                                <option value="Langstroth">Langstroth</option>
                                <option value="Dadant">Dadant</option>
                                <option value="Layens">Layens</option>
                                <option value="Top-Bar">Top-Bar</option>
                                <option value="Warre">Warre</option>
                                <option value="Flow">Flow</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="ml-4">
                                {{ __('Create') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
