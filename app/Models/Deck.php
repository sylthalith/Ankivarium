<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    protected $fillable = ['user_id', 'name', 'total_cards'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stats()
    {
        return $this->hasOne(DeckDailyStat::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function studySession()
    {
        return $this->hasOne(StudySession::class);
    }
}
