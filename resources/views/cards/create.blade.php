<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Upload Pokémon Card
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-100">

                @if ($errors->any())
                    <div class="mb-4 rounded border border-red-600 bg-red-900/20 p-4">
                        <ul class="list-disc pl-5 text-red-200">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('cards.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block mb-1">Naam</label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="w-full rounded-md border-gray-700 bg-gray-900 text-gray-100"
                            required
                        />
                    </div>

                    <div>
                        <label class="block mb-1">Rarity</label>
                        <select
                            name="rarity"
                            class="w-full rounded-md border-gray-700 bg-gray-900 text-gray-100"
                            required
                        >
                            @foreach ($rarities as $r)
                                <option value="{{ $r }}" {{ old('rarity') === $r ? 'selected' : '' }}>
                                    {{ $r }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1">Omschrijving</label>
                        <textarea
                            name="description"
                            rows="4"
                            class="w-full rounded-md border-gray-700 bg-gray-900 text-gray-100"
                        >{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="block mb-1">Afbeelding (optioneel)</label>
                        <input
                            type="file"
                            name="image"
                            class="block w-full text-gray-100"
                            accept=".jpg,.jpeg,.png,.webp"
                        />
                        <p class="text-gray-400 text-sm mt-1">Max 2MB. JPG/PNG/WebP.</p>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="rounded-md px-4 py-2 bg-gray-700 text-gray-100 hover:bg-gray-600">
                            Upload
                        </button>

                        <a href="{{ route('cards.index') }}" class="underline hover:text-gray-300 self-center">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
