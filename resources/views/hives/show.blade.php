<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Hive Details') }}: {{ $hive->name }}
            </h2>
            <div>
                <a href="{{ route('hives.edit', $hive) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Edit') }}
                </a>
                <form class="inline-block ml-4" action="{{ route('hives.destroy', $hive) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Main Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Main Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><strong>Name:</strong> {{ $hive->name }}</div>
                        <div><strong>Slug:</strong> {{ $hive->slug }}</div>
                        <div><strong>QR Code:</strong> {{ $hive->qr_code ?: 'N/A' }}</div>
                        <div><strong>Rating:</strong> {{ $hive->rating }} / 100</div>
                        <div><strong>Type:</strong> {{ $hive->type }}</div>
                        <div><strong>Birth Date:</strong> {{ $hive->birth_date ? $hive->birth_date->format('Y-m-d') : 'N/A' }}</div>
                        <div><strong>Location:</strong> {{ $hive->location ?: 'N/A' }}</div>
                        <div><strong>Status:</strong> {{ $hive->status }}</div>
                        <div class="md:col-span-2"><strong>Notes:</strong> {{ $hive->notes ?: 'N/A' }}</div>
                    </div>
                </div>
            </div>

            <!-- Queen Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Queen Details</h3>
                    @if ($hive->queen)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><strong>Breed:</strong> {{ $hive->queen->breed ?: 'N/A' }}</div>
                            <div><strong>Introduction Date:</strong> {{ $hive->queen->introduction_date ? $hive->queen->introduction_date->format('Y-m-d') : 'N/A' }}</div>
                            <div><strong>Age:</strong> {{ $hive->queen->age ? $hive->queen->age . ' months' : 'N/A' }}</div>
                        </div>
                    @else
                        <p>No active queen information available.</p>
                    @endif
                </div>
            </div>

            <!-- Tags -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Tags</h3>
                    @forelse ($hive->tags as $tag)
                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $tag->name }}</span>
                    @empty
                        <p>No tags associated with this hive.</p>
                    @endforelse
                </div>
            </div>

            <!-- History Tables -->
            <!-- Queen History -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Queen History</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Change Date</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th></tr></thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($hive->queenHistories as $history)
                                <tr><td class="px-6 py-4">{{ $history->change_date->format('Y-m-d') }}</td><td class="px-6 py-4">{{ $history->reason }}</td><td class="px-6 py-4">{{ $history->notes }}</td></tr>
                            @empty
                                <tr><td colspan="3" class="px-6 py-4">No queen history found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Inspections -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Inspections</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                         <thead><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Population</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pests/Diseases</th></tr></thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($hive->inspections as $inspection)
                                <tr><td class="px-6 py-4">{{ $inspection->inspection_date->format('Y-m-d') }}</td><td class="px-6 py-4">{{ $inspection->population }}</td><td class="px-6 py-4">{{ $inspection->pests_diseases }}</td></tr>
                            @empty
                                <tr><td colspan="3" class="px-6 py-4">No inspection history found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Events -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Events</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th></tr></thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($hive->events as $event)
                                <tr><td class="px-6 py-4">{{ $event->event_date->format('Y-m-d') }}</td><td class="px-6 py-4">{{ $event->type }}</td><td class="px-6 py-4">{{ $event->details }}</td></tr>
                            @empty
                                <tr><td colspan="3" class="px-6 py-4">No events found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
