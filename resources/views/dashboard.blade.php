<div class="max-w-3xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-4">I miei Secret Santa</h1>

    <div class="mb-4">
        <a href="{{ route('secret-santas.create') }}"
            class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">+ crea un nuovo Secret Santa</a>
    </div>

    @if ($secretSantas->count())
        <ul class="space-y-2">
            @foreach ($secretSantas as $secretSanta)
                <li class="border p-3 rounded flex justify-between items-center">
                    <div>
                        <span class="font-semibold">{{ $secretSanta->name }}</span>\
                        <span class="text-sm text-gray-500 ml-2">{{ $secretSanta->created_at->format('d/m/y') }}</span>
                    </div>

                    <div class="space-x-2">
                        <a href="#"
                            class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">Visualizza</a>
                        <a href="#"
                            class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Modifica</a>
                        <form action="#" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Elimina</button>

                        </form>

                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-600">Non hai ancora creato nessun Secret Santa.</p>
    @endif


</div>
