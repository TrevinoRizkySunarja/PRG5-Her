<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-200 leading-tight">
                Pokémon Cards
            </h2>

            @auth
                <a href="{{ route('cards.create') }}"
                   class="rounded-md px-4 py-2 bg-gray-700 text-gray-100 hover:bg-gray-600 w-full md:w-auto text-center">
                    Upload Card
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Search + filter --}}
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <form method="GET" action="{{ route('cards.index') }}" class="flex flex-col md:flex-row gap-3 md:items-center">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Zoek op naam of beschrijving..."
                        class="w-full md:flex-1 rounded-md border-gray-700 bg-gray-900 text-gray-100"
                    />

                    <select
                        name="rarity"
                        class="w-full md:w-56 rounded-md border-gray-700 bg-gray-900 text-gray-100"
                    >
                        <option value="all" {{ request('rarity', 'all') === 'all' ? 'selected' : '' }}>
                            Alle rarities
                        </option>

                        @foreach ($rarities as $r)
                            <option value="{{ $r }}" {{ request('rarity', 'all') === $r ? 'selected' : '' }}>
                                {{ $r }}
                            </option>
                        @endforeach
                    </select>

                    <button
                        type="submit"
                        class="w-full md:w-auto rounded-md px-6 py-2 bg-gray-700 text-gray-100 hover:bg-gray-600"
                    >
                        Zoeken
                    </button>
                </form>
            </div>

            {{-- Table --}}
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left table-auto">
                            <thead class="text-gray-300 border-b border-gray-700">
                            <tr>
                                <th class="py-3 px-3 w-20">IMG</th>
                                <th class="py-3 px-3">NAAM</th>
                                <th class="py-3 px-3 w-28">RARITY</th>
                                <th class="py-3 px-3">OMSCHRIJVING</th>
                                <th class="py-3 px-3 w-32">OWNER</th>
                                <th class="py-3 px-3 w-24">STATUS</th>
                                <th class="py-3 px-3 w-40 text-right">ACTIES</th>
                            </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-700">
                            @forelse ($cards as $card)
                                <tr class="align-middle">
                                    <td class="py-3 px-3">
                                        @if ($card->image_path)
                                            <img
                                                src="{{ asset('storage/' . $card->image_path) }}"
                                                alt="{{ $card->name }}"
                                                class="w-12 h-12 object-cover rounded"
                                            />
                                        @else
                                            <div class="w-12 h-12 bg-gray-900 rounded border border-gray-700"></div>
                                        @endif
                                    </td>

                                    <td class="py-3 px-3 font-semibold">
                                        {{ $card->name }}
                                    </td>

                                    <td class="py-3 px-3">
                                        {{ $card->rarity }}
                                    </td>

                                    <td class="py-3 px-3">
                                        {{ \Illuminate\Support\Str::limit($card->description, 40) }}
                                    </td>

                                    <td class="py-3 px-3">
                                        {{ $card->user?->name ?? '-' }}
                                    </td>

                                    <td class="py-3 px-3">
                                        @if ($card->is_active)
                                            <span class="rounded px-2 py-1 text-xs bg-green-900/30 border border-green-700 text-green-200">
                                                    Active
                                                </span>
                                        @else
                                            <span class="rounded px-2 py-1 text-xs bg-red-900/30 border border-red-700 text-red-200">
                                                    Inactive
                                                </span>
                                        @endif
                                    </td>

                                    <td class="py-3 px-3 text-right">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('cards.show', $card) }}" class="underline hover:text-gray-300">
                                                Details
                                            </a>

                                            @auth
                                                @can('toggleStatus', $card)
                                                    <form method="POST" action="{{ route('cards.toggle-status', $card) }}">
                                                        @csrf
                                                        <button type="submit" class="underline hover:text-gray-300">
                                                            Toggle
                                                        </button>
                                                    </form>
                                                @endcan
                                            @endauth
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-6 px-3 text-gray-300">
                                        Geen cards gevonden.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $cards->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
