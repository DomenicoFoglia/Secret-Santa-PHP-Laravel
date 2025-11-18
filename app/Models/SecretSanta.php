<?php

namespace App\Models;

use App\Models\Draw;
use App\Models\Participant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SecretSanta extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function draws()
    {
        return $this->hasMany(Draw::class);
    }

    public function performDraw()
    {
        //Recupero tutti i partecipanti
        $givers = $this->participants;

        //Controllo che siano alemeno 2 (Se siete in 2 non vi serve e  ja -.-)
        if ($givers->count() < 2) {
            return false;
        }

        // Elimina eventuali draw esistenti
        $this->draws()->delete();

        //tentativi massimi per evitare un loop infinito
        $maxAttempts = 100;
        $attempt = 0;


        do {

            $attempt++;

            //Controllo
            $isValid = true;
            //Array di supporto
            $draws = [];

            // Clona i donatori, li mescola e li assegna a ricevitori 
            $receivers = $givers->shuffle();
            $receiversArray = $receivers->values()->all();

            //Cicliamo su i donatori
            foreach ($givers as $index => $giver) {
                $receiver = $receiversArray[$index];

                // Verifica che non ci sia un "autoregalo", se lo trova interrompe il ciclo e ricomincia
                if ($giver->id === $receiver->id) {
                    $isValid = false;
                    break;
                }

                // Se è valido, aggiungiamo la coppia all'array $draws
                $draws[] = [
                    'secret_santa_id' => $this->id,
                    'giver_id' => $giver->id,
                    'receiver_id' => $receiver->id,
                ];
            }

            //Controllo sui tentativi, se si e' arrivati a 100 interrompi. Piu' che altro serve per non far sembrare che sia bloccato
            if ($attempt >= $maxAttempts) {
                throw new \Exception('Impossibile generare un draw valido. Riprova.');
            }
        } while (!$isValid);

        //Salviamo tutto nella tabella
        Draw::insert($draws);

        return 'Sorteggio completato con successo!';
    }
}
