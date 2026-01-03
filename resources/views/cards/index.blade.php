<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Pokémon Cards
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (Route::has('login'))
                <div class="flex justify-end mb-4">
                    @auth
                        <a href="{{ route('cards.create') }}"
                           class="rounded-md px-4 py-2 bg-gray-700 text-gray-100 hover:bg-gray-600">
                            + Upload Card
                        </a>
                    @endauth
                </div>
            @endif


            {{-- Search + filter --}}
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <form method="GET" action="{{ route('cards.index') }}" class="flex flex-col md:flex-row gap-3">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Zoek op naam of beschrijving..."
                        class="w-full md:flex-1 rounded-md border-gray-700 bg-gray-900 text-gray-100"
                    />

                    <select
                        name="rarity"
                        class="w-full md:w-48 rounded-md border-gray-700 bg-gray-900 text-gray-100"
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
                        class="rounded-md px-4 py-2 bg-gray-700 text-gray-100 hover:bg-gray-600"
                    >
                        Zoeken
                    </button>
                </form>
            </div>

            {{-- Table --}}
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left">
                            <thead class="text-gray-300 border-b border-gray-700">
                            <tr>
                                <th class="py-3 pr-4">IMG</th>
                                <th class="py-3 pr-4">NAAM</th>
                                <th class="py-3 pr-4">RARITY</th>
                                <th class="py-3 pr-4">OMSCHRIJVING</th>
                                <th class="py-3 pr-4">OWNER</th>
                                <th class="py-3 pr-4">ACTIES</th>
                            </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-700">
                            @forelse ($cards as $card)
                                <tr>
                                    <td class="py-3 pr-4">
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
                                    <td class="py-3 pr-4 font-semibold">{{ $card->name }}</td>
                                    <td class="py-3 pr-4">{{ $card->rarity }}</td>
                                    <td class="py-3 pr-4">
                                        {{ \Illuminate\Support\Str::limit($card->description, 30) }}
                                    </td>
                                    <td class="py-3 pr-4">{{ $card->user?->name ?? '-' }}</td>
                                    <td class="py-3 pr-4">
                                        <a href="{{ route('cards.show', $card) }}" class="underline hover:text-gray-300">
                                            Details
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-6 text-gray-300">
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
