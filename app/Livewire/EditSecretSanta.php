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

        //Aggiorno nome dell'evento
        $this->secretSanta->update([
            'name' => $this->name,
        ]);

        //Elimino i vecchi parrtecipanti
        $this->secretSanta->participants()->delete();

        //Inserisco i nuovi
        foreach ($this->participants as $participant) {
            $this->secretSanta->participants()->create([
                'name' => $participant['name'],
                'email' => $participant['email'],
            ]);
        }

        session()->flash('success', 'Secret Santa aggiornato con successo!');

        return redirect()->route('secret-santas.edit', $this->secretSanta->id);
    }


    public function render()
    {
        return view('livewire.edit-secret-santa');
    }
}
