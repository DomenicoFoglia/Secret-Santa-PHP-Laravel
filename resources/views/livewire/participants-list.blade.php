<div>
    <div class="block">
        <form action="" wire:submit.prevent="addParticipant">
            <div class="mb-3">
                <label for="name">Nome: </label>
                <input type="text" name="name" id="name" placeholder="Nome" wire:model= "name">
            </div>

            <div class="mb-3">
                <label for="name">Email: </label>
                <input type="email" name="email" id="email" placeholder="Email" wire:model= "email">
            </div>

            <button type="submit">Aggiungi!</button>
        </form>
    </div>

    <div>
        <div>
            <div class="block">
                <form action="" wire:submit.prevent="addParticipant">
                    <div class="mb-3">
                        <label for="name">Nome: </label>
                        <input type="text" name="name" id="name" placeholder="Nome" wire:model= "name">
                    </div>

                    <div class="mb-3">
                        <label for="name">Email: </label>
                        <input type="email" name="email" id="email" placeholder="Email" wire:model= "email">
                    </div>

                    <button type="submit">Aggiungi!</button>
                </form>
            </div>

            <div>
                <ul>
                    @foreach ($participants as $participant)
                        <li>{{ $participant->name }}</li>
                    @endforeach
                </ul>

            </div>
        </div>

        <ul>
            @foreach ($participants as $participant)
                <li>{{ $participant->name }}</li>
            @endforeach
        </ul>

    </div>
</div>
