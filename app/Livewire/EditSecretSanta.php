<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SecretSanta;
use Illuminate\Support\Facades\Auth;

class EditSecretSanta extends Component
{
    public $secretSanta;
    public $name;
    public $participants = [];
    protected $redirects = true;

    public function mount(SecretSanta $secretSanta)
    {
        $this->secretSanta = $secretSanta;
        $this->name = $secretSanta->name;
        $this->participants = $secretSanta->participants->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'email' => $p->email,
                'favorite_gifts' => $p->favoriteGifts()->pluck('name')->toArray(), //pluck serve per estrarre un campo specifico da una query e lo restituiscec sotto forma di array
            ];
        })->toArray();
        //toArray() serve per trasformare la collection in array
    }

    public function removeParticipant($index)
    {
        //Togliamo il partecipantte e riindicizziamo l'array per far funzionare bene il foreach nella vista
        unset($this->participants[$index]);
        $this->participants = array_values($this->participants);
    }

    public function addParticipant()
    {
        //Aggiungo un partecipante vuoto cosi livewire  aggiunge automaticamente nel form i campi da poter riempire
        $this->participants[] = [
            'name' => '',
            'email' => '',
        ];
    }

    public function update()
    {

        if (Auth::id() !== $this->secretSanta->user_id) {
            abort(403);
        }


        $this->validate([
            // Validazione evento
            'name' => 'required|string|max:255',

            // Validazione partecipanti
            'participants' => 'required|array|min:2',
            'participants.*.name' => 'required|string|max:255',
            'participants.*.email' => 'required|email|max:255|distinct',

            // Validazione regali preferiti
            'participants.*.favorite_gifts' => 'nullable|array',
            'participants.*.favorite_gifts.*' => 'required|string|max:255',
        ], [
            // Messaggi evento
            'name.required' => "Il nome dell'evento è obbligatorio.",
            'name.string' => "Il nome deve essere una stringa di testo.",
            'name.max' => "Il nome dell'evento non può superare i :max caratteri.",

            // Messaggi partecipanti
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

            // Messaggi regali
            'participants.*.favorite_gifts.*.required' => "Il nome del regalo è obbligatorio.",
            'participants.*.favorite_gifts.*.string' => "Il regalo deve essere un testo.",
            'participants.*.favorite_gifts.*.max' => "Il regalo non può superare i :max caratteri.",
        ]);

        //Aggiorno nome dell'evento
        $this->secretSanta->update([
            'name' => $this->name,
        ]);


        foreach ($this->participants as $participant) {

            // Partecipante esistente
            if (isset($participant['id'])) {
                $existingParticipant = $this->secretSanta->participants()->find($participant['id']);
                if ($existingParticipant) {
                    // Aggiorna nome ed email
                    $existingParticipant->update([
                        'name' => $participant['name'],
                        'email' => $participant['email'],
                    ]);

                    // Gestione regali
                    $existingGifts = $existingParticipant->favoriteGifts()->pluck('name')->toArray();
                    $submittedGifts = $participant['favorite_gifts'] ?? [];

                    // Regali da eliminare
                    $toDelete = array_diff($existingGifts, $submittedGifts);
                    $existingParticipant->favoriteGifts()->whereIn('name', $toDelete)->delete();

                    // Regali da aggiungere
                    $toAdd = array_diff($submittedGifts, $existingGifts);
                    foreach ($toAdd as $giftName) {
                        $existingParticipant->favoriteGifts()->create([
                            'name' => $giftName,
                        ]);
                    }
                }
            }
            // Nuovo partecipante
            else {
                $newParticipant = $this->secretSanta->participants()->create([
                    'name' => $participant['name'],
                    'email' => $participant['email'],
                ]);

                // Aggiungi regali preferiti
                foreach ($participant['favorite_gifts'] ?? [] as $giftName) {
                    $newParticipant->favoriteGifts()->create([
                        'name' => $giftName,
                    ]);
                }
            }
        }

        session()->flash('success', 'Secret Santa aggiornato con successo!');

        return redirect()->route('secret-santas.edit', $this->secretSanta->id);
    }

    //Aggiungi regalo
    public function addGift($index)
    {
        $this->participants[$index]['favorite_gifts'][] = '';
    }

    //Rimuovi regalo
    public function removeGift($index, $giftIndex)
    {
        unset($this->participants[$index]['favorite_gifts'][$giftIndex]);

        $this->participants[$index]['favorite_gifts'][] = array_values($this->participants[$index]['favorite_gifts']);
    }


    public function render()
    {
        return view('livewire.edit-secret-santa');
    }
}
