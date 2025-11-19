<x-layout>


    <div class="max-w-3xl mx-auto ">

        {{-- <h1 class="text-3xl font-extrabold mb-8 text-center text-gray-800">
            🎁 I miei Secret Santa
        </h1> --}}
        <div class="flex justify-center -mt-20">
            <img src="{{ asset('images/GiftChaos-Logo-nobg.png') }}" alt="Logo" class="h-50">
        </div>


        <div class="mb-8 text-center">
            <a href="{{ route('secret-santas.create') }}"
                class="px-5 py-3 rounded-lg font-bold bg-indigo-600 text-white hover:bg-indigo-700 transition duration-150 ease-in-out shadow-lg transform hover:scale-[1.01]">
                + Crea un nuovo Secret Santa +
            </a>
        </div>

        @if ($secretSantas->count())
            <ul class="space-y-4">
                @foreach ($secretSantas as $secretSanta)
                    <li
                        class="bg-white p-5 rounded-xl shadow-lg border border-gray-100 flex justify-between items-center transition duration-150 ease-in-out hover:shadow-xl hover:border-indigo-200">

                        <div class="mr-6">
                            <span class="text-xl font-bold text-gray-800 block">{{ $secretSanta->name }}</span>
                            <span class="text-sm text-gray-500 mt-1 flex items-center">
                                📅 Creato il: {{ $secretSanta->created_at->format('d/m/Y') }}
                            </span>
                        </div>

                        <div class="flex space-x-2 items-center">

                            <a href="{{ route('secret-santas.show', $secretSanta->id) }}"
                                class="bg-blue-600 text-white px-3 py-2 text-sm rounded-lg font-medium hover:bg-blue-700 transition duration-150 ease-in-out">
                                🔍 Visualizza
                            </a>

                            <a href="{{ route('secret-santas.edit', $secretSanta->id) }}"
                                class="bg-yellow-500 text-white px-3 py-2 text-sm rounded-lg font-medium hover:bg-yellow-600 transition duration-150 ease-in-out">
                                ✏️ Modifica
                            </a>

                            <form action="{{ route('secret-santas.destroy', $secretSanta->id) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="bg-red-500 text-white px-3 py-2 text-sm rounded-lg font-medium hover:bg-red-600 transition duration-150 ease-in-out"
                                    onclick="return confirm('Sei sicuro di voler eliminare {{ $secretSanta->name }}?');">
                                    🗑️ Elimina
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="p-6 bg-white border border-dashed border-gray-400 rounded-lg text-center">
                <p class="text-lg text-gray-700 font-semibold mb-2">Non hai ancora creato nessun Secret Santa.</p>
                <p class="text-gray-500">Inizia ora per organizzare la tua festa natalizia!</p>
            </div>
        @endif


    </div>
</x-layout>
