<?php

namespace App\Models;

use App\Models\Participant;
use App\Models\SecretSanta;
use Illuminate\Database\Eloquent\Model;

class Draw extends Model
{
    protected $fillable = ['secret_santa_id', 'giver_id', 'receiver_id'];

    public function secretSanta()
    {
        return $this->belongsTo(SecretSanta::class);
    }

    //Dobbiamo specificare cosa andare a cercare altrimenti prende in automatico 'participant_id' che non esiste
    public function giver()
    {
        return $this->belongsTo(Participant::class, 'giver_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Participant::class, 'receiver_id');
    }
}
