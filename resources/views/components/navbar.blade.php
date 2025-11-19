<nav class="bg-white shadow sticky top-0 z-50" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-16 flex justify-between items-center">

            <!-- SINISTRA: logo -->
            <a href="{{ route('dashboard') }}" class="flex items-center">
                <img src="{{ asset('images/GiftChaos-Logo-nobg.png') }}" alt="Logo" class="h-20">
            </a>

            <!-- DESKTOP links -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-red-600 transition">
                    Dashboard
                </a>

                <a href="{{ route('secret-santas.create') }}" class="text-gray-700 hover:text-red-600 transition">
                    Crea nuovo
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-gray-700 hover:text-red-600 transition">
                        Logout
                    </button>
                </form>
            </div>

            <!-- MOBILE hamburger -->
            <button @click="open = !open"
                class="md:hidden text-gray-700 hover:text-red-600 transition focus:outline-none">
                <!-- Icona hamburger -->
                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 6h16M4 12h16M4 18h16" />
                </svg>

                <!-- Icona X -->
                <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

        </div>
    </div>

    <!-- MOBILE menu -->
    <div class="md:hidden px-4 pt-3 pb-4 space-y-3 bg-white border-t" x-show="open" x-transition>
        <a href="{{ route('dashboard') }}" class="block text-gray-700 hover:text-red-600 transition">
            Dashboard
        </a>

        <a href="{{ route('secret-santas.create') }}" class="block text-gray-700 hover:text-red-600 transition">
            Crea nuovo
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="block text-gray-700 hover:text-red-600 transition w-full text-left">
                Logout
            </button>
        </form>
    </div>
</nav>
