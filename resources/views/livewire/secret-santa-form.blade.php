<div class="p-8 max-w-lg mx-auto bg-white rounded-2xl shadow-xl ">

    {{-- Titolo --}}
    <h2 class="text-3xl font-extrabold mb-6 text-gray-800 text-center">
        🎄 Crea un nuovo Secret Santa
    </h2>

    <form wire:submit.prevent="save" class="space-y-6">

        {{-- Nome evento --}}
        <div>
            <label for="eventName" class="block text-sm font-semibold mb-1 text-gray-700">Nome evento</label>
            <input id="eventName" type="text" wire:model="name"
                class="w-full border-gray-300 rounded-lg p-3 focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 shadow-sm">
            @error('name')
                <span class="text-red-500 text-xs italic block mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Partecipanti --}}
        <div>
            <label class="block text-lg font-semibold mb-3 text-gray-700 border-b pb-2">
                👥 Partecipanti
            </label>

            @foreach ($participants as $index => $participant)
                <div class="mb-4 border border-gray-200 rounded-lg p-4 bg-gray-50 relative shadow-sm">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <input type="text" placeholder="Nome" wire:model="participants.{{ $index }}.name"
                                class="w-full border-gray-300 rounded-lg p-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error("participants.$index.name")
                                <span class="text-red-500 text-xs italic block mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <input type="email" placeholder="Email"
                                wire:model="participants.{{ $index }}.email"
                                class="w-full border-gray-300 rounded-lg p-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error("participants.$index.email")
                                <span class="text-red-500 text-xs italic block mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- rimuovi --}}
                    <button type="button" wire:click="removeParticipant({{ $index }})"
                        class="absolute -top-2 -right-2 text-white bg-red-600 hover:bg-red-700 rounded-full w-7 h-7 flex items-center justify-center text-base font-bold transition duration-150 shadow-md">
                        ×
                    </button>
                </div>
            @endforeach

            {{-- aggiungi --}}
            <button type="button" wire:click="addParticipant"
                class="mt-2 text-indigo-600 text-sm font-semibold hover:text-indigo-800 transition duration-150 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Aggiungi partecipante
            </button>
        </div>

        {{-- Salva --}}
        <button type="submit"
            class="bg-green-600 text-white px-5 py-3 rounded-lg font-bold hover:bg-green-700 w-full transition duration-150 ease-in-out shadow-lg transform hover:scale-[1.005]">
            Salva e Continua
        </button>
    </form>

    {{-- Torna alla Dashboard --}}
    <a href="{{ route('dashboard') }}"
        class="text-gray-500 hover:text-gray-700 transition duration-150 mt-6 inline-block text-sm font-medium">
        ← Torna alla Dashboard
    </a>
</div>
