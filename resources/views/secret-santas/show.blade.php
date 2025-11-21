<x-layout>
    @if (session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 border border-green-300">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 border border-red-300">
            {{ session('error') }}
        </div>
    @endif
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

                    {{-- Nome --}}
                    <h2 class="font-bold text-xl text-gray-800 truncate">{{ $participant->name }}</h2>

                    {{-- Email --}}
                    <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                        📧 {{ $participant->email }}
                    </p>

                    {{-- Regali preferiti --}}
                    @if ($participant->favoriteGifts->count() > 0)
                        <div class="mt-3">
                            <h3 class="text-sm font-semibold text-gray-700 mb-1">🎁 Regali preferiti</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($participant->favoriteGifts as $gift)
                                    <div class="relative gift-wrapper">
                                        {{-- Bottone regalo --}}
                                        <button
                                            class="gift-btn bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium flex items-center gap-1 hover:scale-105 hover:shadow-md transition-transform"
                                            data-gift="{{ $gift->name }}">
                                            🎁 {{ $gift->name }}
                                        </button>

                                        {{-- Box pubblicitario nascosto --}}
                                        <div
                                            class="gift-ad absolute z-10 mt-2 w-64 bg-white border border-gray-300 rounded-md shadow-lg p-3 text-sm hidden">
                                            <p class="font-semibold text-gray-700 mb-2">Annuncio per:
                                                {{ $gift->name }}</p>
                                            <img src="https://via.placeholder.com/150?text={{ urlencode($gift->name) }}"
                                                alt="{{ $gift->name }}" class="mb-2 w-full rounded">
                                            <p class="text-gray-600 text-sm">Acquista questo regalo online! Offerte
                                                disponibili.</p>
                                            <a href="#" class="text-blue-600 hover:underline text-sm">Vai al
                                                negozio</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

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

                <form action="{{ route('secret-santas.draw', $secretSanta->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                        class="px-5 py-3 rounded-lg font-medium bg-green-600 text-white hover:bg-green-700 transition duration-150 ease-in-out shadow-md">🎉
                        Fai l'Estrazione</button>
                </form>

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
    @if ($draws->count() > 0)
        <h2 class="text-2xl font-bold mb-4 text-gray-700 border-b pb-2">🎁 Risultati del Sorteggio</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            @foreach ($draws as $draw)
                <div
                    class="p-5 bg-white rounded-xl shadow-md border border-gray-200 transition duration-150 hover:shadow-lg hover:border-blue-300">
                    <p class="text-gray-800 font-bold">
                        {{ $draw->giver->name }} &rarr; {{ $draw->receiver->name }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1 flex items-center">
                        📧 {{ $draw->receiver->email }}
                    </p>
                </div>
            @endforeach
        </div>

        <form action="{{ route('secret-santas.send-emails', $secretSanta->id) }}" method="POST" class="mb-5">
            @csrf
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Invia email
                ai partecipanti</button>
        </form>


    @endif

    {{-- Script per annunci --}}
    <script>
        document.querySelectorAll('.gift-wrapper').forEach(wrapper => {
            const btn = wrapper.querySelector('.gift-btn');
            const ad = wrapper.querySelector('.gift-ad');
            btn.addEventListener('click', () => {
                ad.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                //Se il click non e' ne sul bottone e ne sul ad (o cmq fuori dal wrapper), chiude la finestra dell ad
                if (!wrapper.contains(e.target)) {
                    ad.classList.add('hidden');
                }
            })
        });
    </script>

</x-layout>
