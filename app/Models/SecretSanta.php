<?php

namespace App\Models;

use App\Models\Draw;
use App\Models\Participant;
use Illuminate\Support\Facades\DB;
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
        $participants = $this->participants;

        if ($participants->count() < 2) {
            throw new \Exception('Servono almeno 2 partecipanti per il sorteggio.');
        }

        return DB::transaction(function () use ($participants) {
            // Elimina eventuali draw esistenti
            $this->draws()->delete();

            // Converti in array per manipolazione
            $participantIds = $participants->pluck('id')->all();

            // Mescola i partecipanti
            shuffle($participantIds);

            $draws = [];
            $count = count($participantIds);

            // Crea un ciclo: ogni persona regala alla successiva
            // L'ultimo regala al primo, creando un anello
            for ($i = 0; $i < $count; $i++) {
                $giverId = $participantIds[$i];
                $receiverId = $participantIds[($i + 1) % $count];

                $draws[] = [
                    'secret_santa_id' => $this->id,
                    'giver_id' => $giverId,
                    'receiver_id' => $receiverId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Inserimento
            Draw::insert($draws);

            return 'Sorteggio completato con successo!';
        });
    }

    /**
     * Verifica se il sorteggio è stato già effettuato
     */

    public function hasDrawn(): bool
    {
        return $this->draws()->exists();
    }

    /**
     * Statistiche 
     */
    public function getStats(): array
    {
        return [
            'total_participants' => $this->participants()->count(),
            'draws_completed' => $this->draws()->count(),
            'is_complete' => $this->hasDrawn(),
        ];
    }
}
