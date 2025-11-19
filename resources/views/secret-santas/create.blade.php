<x-layout>
    <div class="max-w-3xl mx-auto ">

        @if (session('message'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif



        <livewire:secret-santa-form />
    </div>
</x-layout>
