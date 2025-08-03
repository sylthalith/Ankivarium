<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudySession extends Model
{
    protected $fillable = ['deck_id'];

    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }

    public function sessionCards()
    {
        return $this->hasMany(SessionCard::class);
    }
}
