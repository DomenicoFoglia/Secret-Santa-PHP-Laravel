<x-layout>
    <div class="max-w-4xl mx-auto p-6 lg:p-8 mt-4">

        {{-- Titolo --}}
        <div class="mb-8">
            <h1 class="text-4xl font-extrabold mb-2 text-gray-800 text-center">
                🎅 {{ $secretSanta->name }}
            </h1>
        </div>

        {{-- CArd partecipanti --}}
        <h2 class="text-2xl font-bold mb-4 text-gray-700 border-b pb-2">👥 Partecipanti</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($participants as $participant)
                <div
                    class="p-5 bg-white rounded-xl shadow-md border border-gray-200 transition duration-150 hover:shadow-lg hover:border-blue-300">
                    <h2 class="font-bold text-xl text-gray-800 truncate">{{ $participant->name }}</h2>
                    <p class="text-sm text-gray-500 mt-1 flex items-center">
                        📧 {{ $participant->email }}
                    </p>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            <h2 class="text-2xl font-bold mb-4 text-gray-700 border-b pb-2">⚙️ Azioni</h2>

            {{-- Pulsanti azione evento --}}
            <div class="flex flex-wrap gap-4 items-center">

                <a href="{{ route('secret-santas.edit', $secretSanta->id) }}"
                    class="px-5 py-3 rounded-lg font-medium bg-yellow-500 text-white hover:bg-yellow-600 transition duration-150 ease-in-out shadow-md">
                    ✏️ Modifica Evento
                </a>

                <form action="{{ route('secret-santas.destroy', $secretSanta->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-5 py-3 rounded-lg font-medium bg-red-500 text-white hover:bg-red-600 transition duration-150 ease-in-out shadow-md"
                        onclick="return confirm('Sei sicuro di voler eliminare definitivamente {{ $secretSanta->name }}?');">
                        🗑️ Elimina Evento
                    </button>
                </form>

                {{-- Estrazione da fare --}}
                <a href="#"
                    class="px-5 py-3 rounded-lg font-medium bg-green-600 text-white hover:bg-green-700 transition duration-150 ease-in-out shadow-md">
                    🎉 Fai l'Estrazione
                </a>
            </div>

            <hr class="my-6">

            {{-- Pulsanti navigazione --}}
            <div class="flex flex-wrap gap-4 items-center">
                <a href="{{ route('dashboard') }}"
                    class="px-5 py-3 rounded-lg font-medium bg-gray-500 text-white hover:bg-gray-600 transition duration-150 ease-in-out shadow-md">
                    ← Torna alla Dashboard
                </a>

                <a href="{{ route('secret-santas.create') }}"
                    class="px-5 py-3 rounded-lg font-medium bg-indigo-600 text-white hover:bg-indigo-700 transition duration-150 ease-in-out shadow-md">
                    + Crea un nuovo Secret Santa
                </a>
            </div>
        </div>
    </div>
</x-layout>
