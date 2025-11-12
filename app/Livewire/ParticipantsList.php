<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Participant;

class ParticipantsList extends Component
{
    public $participants;
    public $name = '';
    public $email = '';

    public function mount()
    {
        $this->participants = Participant::all();
    }

    public function addParticipant()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:participants,email'
        ]);

        //Aggiungi partecipante
        $participant = Participant::create([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        //Inseriscilo nella lista
        $this->participants->push($participant);

        // Puliamo il form
        $this->name = '';
        $this->email = '';
    }

    public function render()
    {
        return view('livewire.participants-list');
    }
}
