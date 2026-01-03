<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Card Details
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-100">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="w-full md:w-64">
                        @if ($card->image_path)
                            <img
                                src="{{ asset('storage/' . $card->image_path) }}"
                                alt="{{ $card->name }}"
                                class="w-full rounded object-cover"
                            />
                        @else
                            <div class="w-full h-64 bg-gray-900 rounded border border-gray-700"></div>
                        @endif
                    </div>

                    <div class="flex-1">
                        <h1 class="text-2xl font-bold mb-2">{{ $card->name }}</h1>
                        <p class="text-gray-300 mb-2"><span class="font-semibold">Rarity:</span> {{ $card->rarity }}</p>
                        <p class="text-gray-300 mb-2"><span class="font-semibold">Owner:</span> {{ $card->user?->name ?? '-' }}</p>

                        @if ($card->description)
                            <div class="mt-4">
                                <p class="font-semibold mb-1">Omschrijving</p>
                                <p class="text-gray-200">{{ $card->description }}</p>
                            </div>
                        @endif

                        <div class="mt-6">
                            <a href="{{ route('cards.index') }}" class="underline hover:text-gray-300">
                                ← Terug naar overzicht
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
