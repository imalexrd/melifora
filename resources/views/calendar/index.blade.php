<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-dark-text-dark">
            {{ __('Calendario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Calendar Section -->
                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-dark-surface">
                        <div class="p-6 text-gray-900 dark:text-dark-text-light" id='calendar'>
                            <!-- Calendar will be rendered here -->
                        </div>
                    </div>
                </div>

                <!-- Tasks and Events Panel -->
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-dark-surface">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 dark:text-dark-text-dark">Próximas Tareas y Eventos</h3>
                            <ul class="space-y-4">
                                @forelse ($events as $event)
                                    <li class="border-l-4 pl-4" style="border-color: {{ $event['color'] }};">
                                        <a href="{{ $event['url'] }}" class="font-semibold text-primary hover:underline">{{ $event['title'] }}</a>
                                        <p class="text-sm text-gray-500 dark:text-dark-text-light">{{ \Carbon\Carbon::parse($event['start'])->format('d/m/Y H:i') }}</p>
                                        <p class="text-sm text-gray-600 dark:text-dark-text-light">{{ $event['description'] }}</p>
                                    </li>
                                @empty
                                    <li>
                                        <p class="text-gray-500 dark:text-dark-text-light">No hay tareas o eventos próximos.</p>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
          },
          events: @json($events),
          eventClick: function(info) {
            info.jsEvent.preventDefault(); // don't let the browser navigate
            if (info.event.url) {
              window.open(info.event.url, "_blank");
            }
          }
        });
        calendar.render();
      });
    </script>
    @endpush
</x-app-layout>
