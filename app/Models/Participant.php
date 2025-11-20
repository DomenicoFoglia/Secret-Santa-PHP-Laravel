<?php

namespace App\Models;

use App\Models\SecretSanta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'secret_santa_id'];

    public function secretSanta()
    {
        return $this->belongsTo(SecretSanta::class);
    }

    public function favoriteGifts()
    {
        return $this->hasMany(FavoriteGift::class);
    }
}
