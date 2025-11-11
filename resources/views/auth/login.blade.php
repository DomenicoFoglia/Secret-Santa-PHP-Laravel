<x-layout>
    @if (session('status'))
        <p class="text-red-500 text-sm mb-4">{{ session('status') }}</p>
    @endif

    <div class="w-full max-w-md bg-green-50 rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6 text-center">Login</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

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

            <div class="flex items-center justify-between mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-2">
                    <span class="text-green-700 text-sm">Ricordami</span>
                </label>
            </div>

            <button type="submit"
                class="w-full bg-red-500 text-white border-2 border-green-600  py-2 rounded hover:bg-red-600 hover:border-green-500 transition">
                Accedi
            </button>
            <div>
                <a href="{{ route('password.request') }}" class="text-green-500 block text-sm">Hai dimenticato la
                    password?</a>
                <a href="{{ route('register') }}" class="text-green-500 text-sm">Non hai un account? Registrati</a>
            </div>

        </form>
    </div>
</x-layout>
