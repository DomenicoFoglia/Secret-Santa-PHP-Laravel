<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SecretSanta;

class SecretSantaForm extends Component
{
    public $name = '';
    public $participants = [
        ['name' => '', 'email' => '', 'favorite_gifts' => ['']]
    ];

    public function addParticipant()
    {
        $this->participants[] = ['name' => '', 'email' => '', 'favorite_gifts' => ['']];
    }

    public function removeParticipant($index)
    {
        unset($this->participants[$index]);
        $this->participants = array_values($this->participants);
    }

    //Aggiungi regalo preferito
    public function addFavoriteGift($participantIndex)
    {
        $this->participants[$participantIndex]['favorite_gifts'][] = '';
    }

    //Rimuovi regalo preferito
    public function removeFavoriteGift($participantIndex, $giftIndex)
    {
        unset($this->participants[$participantIndex]['favorite_gift'][$giftIndex]);

        $this->participants[$participantIndex]['favorite_gifts'] =  array_values($this->participants[$participantIndex]['favorite_gifts']);
    }

    public function save()
    {
        $this->validate(
            [
                'name' => 'required|string|max:255',
                'participants' => 'required|array|min:2',
                'participants.*.name' => 'required|string|max:255',
                'participants.*.email' => 'required|email|max:255|distinct',
            ],
            [
                'name.required' => "Il nome dell'evento è obbligatorio.",
                'name.string' => "Il nome deve essere una stringa di testo.",
                'name.max' => "Il nome dell'evento non può superare i :max caratteri.",

                'participants.required' => "Devi inserire almeno due partecipanti.",
                'participants.array' => "I partecipanti devono essere un elenco.",
                'participants.min' => "Sono richiesti almeno :min partecipanti per un Secret Santa.",

                'participants.*.name.required' => "Il nome del partecipante è obbligatorio.",
                'participants.*.name.string' => "Il nome del partecipante deve essere una stringa di testo.",
                'participants.*.name.max' => "Il nome del partecipante non può superare i :max caratteri.",

                'participants.*.email.required' => "L'email del partecipante è obbligatoria.",
                'participants.*.email.email' => "L'indirizzo email non è valido.",
                'participants.*.email.max' => "L'indirizzo email non può superare i :max caratteri.",
                'participants.*.email.distinct' => "L'indirizzo email ':input' è già stato inserito. Le email devono essere univoche.",
            ]
        );

        $secretSanta = SecretSanta::create([
            'name' => $this->name,
            'user_id' => auth()->id(),
        ]);

        foreach ($this->participants as $p) {
            // creo il partecipante
            $participant = $secretSanta->participants()->create([
                'name' => $p['name'],
                'email' => $p['email'],
            ]);

            // creo tutti i regali preferiti del partecipante
            foreach ($p['favorite_gifts'] as $giftName) {
                if (!empty($giftName)) {
                    $participant->favoriteGifts()->create([
                        'name' => $giftName
                    ]);
                }
            }
        }

        //reset
        $this->name = '';
        $this->participants = [['name' => '', 'email' => '', 'favorite_gifts' => ['']]];

        session()->flash('message', 'Secret Santa creato con successo!');
    }

    public function render()
    {
        return view('livewire.secret-santa-form');
    }
}
