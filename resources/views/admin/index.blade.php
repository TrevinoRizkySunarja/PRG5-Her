<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Admin Panel
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-100">
                <p class="text-gray-300 mb-4">
                    Dit scherm is alleen voor admins. Hier kan ik bijvoorbeeld alle cards monitoren.
                </p>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-left table-auto">
                        <thead class="text-gray-300 border-b border-gray-700">
                        <tr>
                            <th class="py-3 px-3">Naam</th>
                            <th class="py-3 px-3">Owner</th>
                            <th class="py-3 px-3">Rarity</th>
                            <th class="py-3 px-3">Status</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                        @foreach($cards as $card)
                            <tr>
                                <td class="py-3 px-3">{{ $card->name }}</td>
                                <td class="py-3 px-3">{{ $card->user?->name ?? '-' }}</td>
                                <td class="py-3 px-3">{{ $card->rarity }}</td>
                                <td class="py-3 px-3">
                                    {{ $card->is_active ? 'Active' : 'Inactive' }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $cards->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
