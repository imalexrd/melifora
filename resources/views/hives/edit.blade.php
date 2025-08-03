<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Hive') }}: {{ $hive->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('hives.update', $hive) }}">
                        @csrf
                        @method('PATCH')

                        <!-- Name -->
                        <div>
                            <label for="name">{{ __('Name') }}</label>
                            <input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name', $hive->name) }}" required autofocus />
                        </div>

                        <!-- Slug -->
                        <div class="mt-4">
                            <label for="slug">{{ __('Slug') }}</label>
                            <input id="slug" class="block mt-1 w-full" type="text" name="slug" value="{{ old('slug', $hive->slug) }}" required />
                        </div>

                        <!-- QR Code -->
                        <div class="mt-4">
                            <label for="qr_code">{{ __('QR Code') }}</label>
                            <input id="qr_code" class="block mt-1 w-full" type="text" name="qr_code" value="{{ old('qr_code', $hive->qr_code) }}" />
                        </div>

                        <!-- Rating -->
                        <div class="mt-4">
                            <label for="rating">{{ __('Rating (0-100)') }}</label>
                            <input id="rating" class="block mt-1 w-full" type="number" name="rating" value="{{ old('rating', $hive->rating) }}" min="0" max="100" />
                        </div>

                        <!-- Type -->
                        <div class="mt-4">
                            <label for="type">{{ __('Type') }}</label>
                            <select id="type" name="type" class="block mt-1 w-full">
                                @foreach (['Langstroth', 'Dadant', 'Layens', 'Top-Bar', 'Warre', 'Flow'] as $type)
                                    <option value="{{ $type }}" @if (old('type', $hive->type) == $type) selected @endif>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Birth Date -->
                        <div class="mt-4">
                            <label for="birth_date">{{ __('Birth Date') }}</label>
                            <input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" value="{{ old('birth_date', $hive->birth_date ? $hive->birth_date->format('Y-m-d') : '') }}" />
                        </div>

                        <!-- Location -->
                        <div class="mt-4">
                            <label for="location">{{ __('Location') }}</label>
                            <input id="location" class="block mt-1 w-full" type="text" name="location" value="{{ old('location', $hive->location) }}" />
                        </div>

                        <!-- Status -->
                        <div class="mt-4">
                            <label for="status">{{ __('Status') }}</label>
                            <select id="status" name="status" class="block mt-1 w-full">
                                @foreach (['Desconocido', 'Activa', 'Invernando', 'Enjambrazon', 'Despoblada', 'Huerfana', 'Zanganera', 'En formacion', 'Revision', 'Mantenimiento', 'Alimentacion Artificial', 'Crianza de reinas', 'Pillaje', 'Pillera', 'Union', 'Sin uso'] as $status)
                                    <option value="{{ $status }}" @if (old('status', $hive->status) == $status) selected @endif>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Notes -->
                        <div class="mt-4">
                            <label for="notes">{{ __('Notes') }}</label>
                            <textarea id="notes" name="notes" class="block mt-1 w-full">{{ old('notes', $hive->notes) }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="ml-4">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
