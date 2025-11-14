<div class="p-6 max-w-md mx-auto bg-white rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4">Crea un nuovo Secret Santa</h2>

    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label class="block text-sm font-medium mb-1">Nome evento</label>
            <input type="text" wire:model="name" class="w-full border rounded p-2">
            @error('name')
                <span class="text-red-500 text-sm block mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Partecipanti --}}
        <div>
            <label class="block text-sm font-medium mb-2">Partecipanti</label>

            @foreach ($participants as $index => $participant)
                <div class="mb-3 border rounded p-3 bg-gray-50 relative">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <div>
                            <input type="text" placeholder="Nome" wire:model="participants.{{ $index }}.name"
                                class="w-full border rounded p-2">
                            @error("participants.$index.name")
                                <span class="text-red-500 text-sm block mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <input type="email" placeholder="Email"
                                wire:model="participants.{{ $index }}.email" class="w-full border rounded p-2">
                            @error("participants.$index.email")
                                <span class="text-red-500 text-sm block mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- rimuovi --}}
                    <button type="button" wire:click="removeParticipant({{ $index }})"
                        class="absolute top-2 right-2 text-white bg-red-500 hover:bg-red-600 rounded-full w-6 h-6 flex items-center justify-center text-sm">
                        ×
                    </button>
                </div>
            @endforeach

            {{-- aggiungi --}}
            <button type="button" wire:click="addParticipant" class="text-blue-500 text-sm hover:underline">+ Aggiungi
                partecipante</button>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full">
            Salva
        </button>
    </form>

    <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:underline mt-4 inline-block">← Torna alla
        Dashboard</a>
</div>
