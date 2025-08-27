@php
    $isTask = $note->type === 'task';
    $statusClass = '';
    if ($isTask) {
        if ($note->completed_at) {
            $statusClass = 'border-green-500'; // Completed
        } elseif ($note->due_date && $note->due_date->isPast()) {
            $statusClass = 'border-red-500'; // Overdue
        } elseif ($note->due_date) {
            $statusClass = 'border-blue-500'; // Upcoming
        }
    } else {
        $statusClass = 'border-gray-300'; // Note
    }
@endphp

<div class="flex items-start space-x-4" id="note-{{ $note->id }}" data-due-date="{{ $isTask && $note->due_date ? $note->due_date->format('Y-m-d\TH:i') : '' }}">
    <img class="w-10 h-10 rounded-full" src="{{ $note->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($note->user->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ $note->user->name }}">
    <div class="flex-1">
        <div class="bg-gray-100 rounded-lg p-4 dark:bg-gray-700 border-l-4 {{ $statusClass }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <p class="font-semibold text-gray-900 dark:text-dark-text-dark">{{ $note->user->name }}</p>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $isTask ? 'bg-blue-200 text-blue-800' : 'bg-gray-200 text-gray-800' }}">
                        {{ ucfirst($note->type) }}
                    </span>
                </div>
                <div class="text-xs text-gray-500 dark:text-dark-text-light">
                    {{ $note->created_at->diffForHumans() }}
                    @if ($note->created_at != $note->updated_at)
                        (editado)
                    @endif
                </div>
            </div>

            @if ($isTask)
                <div class="flex items-center space-x-2 mt-2">
                    <input type="checkbox" class="task-checkbox rounded border-gray-300 text-primary shadow-sm focus:border-primary-light focus:ring focus:ring-primary-light focus:ring-opacity-50" data-note-id="{{ $note->id }}" {{ $note->completed_at ? 'checked' : '' }} {{ auth()->id() != $note->user_id ? 'disabled' : '' }}>
                    <p class="text-gray-700 note-content dark:text-dark-text-light {{ $note->completed_at ? 'line-through' : '' }}">{{ $note->content }}</p>
                </div>
                <div class="flex items-center space-x-4 text-xs text-gray-500 mt-1 dark:text-dark-text-light">
                    <div>
                        <strong>Vence:</strong> {{ $note->due_date ? $note->due_date->format('d/m/Y H:i') : 'N/A' }}
                    </div>
                    <div class="task-status">
                        <strong>Estado:</strong>
                        @if ($note->completed_at)
                            <span class="font-semibold text-green-600">Completada</span>
                        @else
                            <span class="font-semibold text-red-600">Pendiente</span>
                        @endif
                    </div>
                </div>
            @else
                <p class="text-gray-700 mt-2 note-content dark:text-dark-text-light">{{ $note->content }}</p>
            @endif
        </div>
        @if (auth()->id() == $note->user_id)
            <div class="flex items-center space-x-4 mt-1 text-xs">
                <button class="font-medium text-blue-600 hover:text-blue-800 edit-note-button dark:text-blue-400 dark:hover:text-blue-300" data-note-id="{{ $note->id }}">Editar</button>
                <button class="font-medium text-red-600 hover:text-red-800 delete-note-button dark:text-red-400 dark:hover:text-red-300" data-note-id="{{ $note->id }}">Eliminar</button>
            </div>

            <div id="edit-note-form-{{ $note->id }}" class="hidden mt-2">
                <textarea class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary-light focus:ring-opacity-50 dark:bg-dark-surface dark:border-gray-600 dark:text-dark-text-dark" rows="3">{{ $note->content }}</textarea>
                @if ($isTask)
                    <div class="mt-2">
                        <label for="edit-due-date-{{ $note->id }}" class="block text-sm font-medium text-gray-700 dark:text-dark-text-light">Fecha de Vencimiento</label>
                        <input type="datetime-local" id="edit-due-date-{{ $note->id }}" name="due_date" value="{{ $note->due_date ? $note->due_date->format('Y-m-d\TH:i') : '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary-light dark:bg-dark-surface dark:border-gray-600 dark:text-dark-text-dark">
                    </div>
                @endif
                <div class="flex justify-end space-x-2 mt-2">
                    <button class="px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 cancel-edit-button dark:bg-gray-600 dark:text-white dark:hover:bg-gray-500" data-note-id="{{ $note->id }}">Cancelar</button>
                    <button class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 confirm-edit-button" data-note-id="{{ $note->id }}">Guardar</button>
                </div>
            </div>
        @endif
    </div>
</div>
