<?php

namespace App\Models;

use App\Models\Participant;
use Illuminate\Database\Eloquent\Model;

class FavoriteGift extends Model
{
    protected $fillable = ['participant_id', 'name', 'description'];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
