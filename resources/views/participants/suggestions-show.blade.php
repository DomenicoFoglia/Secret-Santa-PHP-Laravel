<x-layout>
    <div class="max-w-4xl mx-auto p-6 lg:p-8 mt-4 bg-white shadow-xl rounded-xl">

        <div class="flex justify-between items-center mb-8 border-b pb-4">
            <h1 class="text-3xl font-extrabold text-gray-800">
                🛒 Suggerimenti regalo per: <span class="text-indigo-600">{{ $participant->name }}</span>
            </h1>
            {{-- Tornare alla pagina show dell'evento usando l'ID dell'evento --}}
            <a href="{{ route('secret-santas.show', $participant->secret_santa_id) }}"
                class="px-4 py-2 text-sm font-medium bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                ← Torna all'Evento
            </a>
        </div>

        @if ($favoriteGifts->isNotEmpty())
            <p class="text-md text-gray-600 mb-6">
                Ricerca basata sui regali preferiti: **{{ $favoriteGifts->pluck('name')->implode(', ') }}**
            </p>
        @else
            <p class="text-md text-gray-500 italic p-4 bg-gray-50 rounded-lg">
                Nessun regalo preferito inserito per questo partecipante.
            </p>
        @endif

        <h2 class="text-2xl font-bold mb-4 text-gray-700 border-b pb-2">Risultati da eBay</h2>

        @if ($ebayItems->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($ebayItems as $item)
                    <div
                        class="border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition duration-150">
                        <a href="{{ $item['url'] }}" target="_blank"
                            class="font-semibold text-blue-600 hover:text-blue-800 text-lg block truncate"
                            title="{{ $item['title'] }}">
                            {{ $item['title'] }}
                        </a>
                        <p class="text-sm text-gray-500 mt-1">Prezzo stimato:</p>
                        <p class="text-lg font-bold text-green-600 mt-1">
                            € @if (is_numeric($item['price']))
                                {{ number_format((float) $item['price'], 2, ',', '.') }}
                            @else
                                {{ $item['price'] }}
                            @endif
                        </p>
                    </div>
                @endforeach
            </div>
        @elseif ($favoriteGifts->isNotEmpty())
            <p class="text-gray-500 italic p-4 bg-yellow-50 rounded-lg">
                Nessun risultato trovato su eBay dopo aver provato le seguenti ricerche:
                <br>
                <span class="font-mono text-xs text-gray-700 mt-1 block">
                    {{ implode(', ', $searchQueries) }}
                </span>
            </p>
        @endif

    </div>
</x-layout>
