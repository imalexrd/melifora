<div class="flex items-start space-x-4" id="note-{{ $note->id }}">
    <img class="w-10 h-10 rounded-full" src="{{ $note->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($note->user->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ $note->user->name }}">
    <div class="flex-1">
        <div class="bg-gray-100 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <p class="font-semibold text-gray-900">{{ $note->user->name }}</p>
                <div class="text-xs text-gray-500">
                    {{ $note->created_at->diffForHumans() }}
                    @if ($note->created_at != $note->updated_at)
                        (editado)
                    @endif
                </div>
            </div>
            <p class="text-gray-700 mt-2 note-content">{{ $note->content }}</p>
        </div>
        @if (auth()->id() == $note->user_id)
            <div class="flex items-center space-x-4 mt-1 text-xs">
                <button class="font-medium text-blue-600 hover:text-blue-800 edit-note-button" data-note-id="{{ $note->id }}">Editar</button>
                <button class="font-medium text-red-600 hover:text-red-800 delete-note-button" data-note-id="{{ $note->id }}">Eliminar</button>
            </div>

            <div id="edit-note-form-{{ $note->id }}" class="hidden mt-2">
                <textarea class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary-light focus:ring-opacity-50" rows="3">{{ $note->content }}</textarea>
                <div class="flex justify-end space-x-2 mt-2">
                    <button class="px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 cancel-edit-button" data-note-id="{{ $note->id }}">Cancelar</button>
                    <button class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 confirm-edit-button" data-note-id="{{ $note->id }}">Guardar</button>
                </div>
            </div>
        @endif
    </div>
</div>
