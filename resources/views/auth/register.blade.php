<x-layout>
    @if (session('status'))
        <p class="text-red-500 text-sm mb-4">{{ session('status') }}</p>
    @endif

    <div class="w-full max-w-md bg-green-50 rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6 text-center">Registrazione</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-green-700 mb-2">Nome</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full px-3 py-2 border border-red-300 rounded focus:outline-none focus:ring focus:border-green-300">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-green-700 mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-3 py-2 border border-red-300 rounded focus:outline-none focus:ring focus:border-green-300">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-green-700 mb-2">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-3 py-2 border border-red-300 rounded focus:outline-none focus:ring focus:border-green-500">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-green-700 mb-2">Conferma password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full px-3 py-2 border border-red-300 rounded focus:outline-none focus:ring focus:border-green-500">
                @error('password_confirmation')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-red-500 text-white font-bold py-2 rounded border-2 border-green-600 hover:bg-red-700 hover:border-green-700 transition">
                Registrati
            </button>
            <a href="{{ route('login') }}" class="text-green-500 text-sm">hai già un account? Effettua il login qui</a>
        </form>
    </div>
</x-layout>
