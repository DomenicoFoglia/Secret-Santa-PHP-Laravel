<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md mt-6">
    @if (session('success'))
        <div class="p-3 mb-4 bg-green-100 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="update" class="space-y-6">

        {{-- Nome evento --}}
        <div>
            <label class="block text-lg font-medium text-gray-700 mb-1">Nome Evento 🎅</label>
            <input type="text" wire:model="name"
                class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>

        {{-- Partecipanti --}}
        <div>
            <h2 class="text-xl font-semibold text-gray-700 mb-2">👥 Partecipanti</h2>

            <div class="space-y-4">
                @foreach ($participants as $index => $participant)
                    <div
                        class="flex flex-col md:flex-row gap-2 items-center p-4 bg-gray-50 rounded-md border border-gray-200">

                        <input type="text" wire:model="participants.{{ $index }}.name" placeholder="Nome"
                            class="flex-1 border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">

                        <input type="email" wire:model="participants.{{ $index }}.email" placeholder="Email"
                            class="flex-1 border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">

                        <button type="button" wire:click="removeParticipant({{ $index }})"
                            class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                            🗑️ Rimuovi Partecipante
                        </button>
                    </div>

                    <div class="mt-3 p-3 bg-gray-50 border border-gray-200 rounded-md">
                        <p class="font-semibold text-gray-500 mb-2">🎁 Regali preferiti:</p>

                        @foreach ($participant['favorite_gifts'] as $giftIndex => $gift)
                            <div class="flex items-center gap-2 mb-2">
                                <input type="text"
                                    wire:model="participants.{{ $index }}.favorite_gifts.{{ $giftIndex }}"
                                    placeholder="Regalo preferito"
                                    class="flex-1 border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">

                                <button type="button" wire:click="removeGift({{ $index }}, {{ $giftIndex }})"
                                    class="text-red-600 hover:text-red-800 font-bold text-lg">×</button>
                            </div>
                        @endforeach

                        <span wire:click="addGift({{ $index }})"
                            class="text-green-600 cursor-pointer hover:text-green-800 font-medium text-sm">
                            ➕ Aggiungi regalo
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Pulsanti --}}
        <div class="flex flex-wrap gap-4 mt-4">
            <button type="button" wire:click="addParticipant()"
                class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                ➕ Aggiungi partecipante
            </button>

            <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                💾 Salva modifiche
            </button>

            <a href="{{ route('dashboard') }}"
                class="px-5 py-3 rounded-lg font-medium bg-gray-500 text-white hover:bg-gray-600 transition duration-150 ease-in-out shadow-md">
                ← Torna alla Dashboard
            </a>
        </div>

    </form>
</div>
