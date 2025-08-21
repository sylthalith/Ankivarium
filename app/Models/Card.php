<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['deck_id', 'front', 'back', 'interval', 'next_review_date', 'reviewed_at','type'];

    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }

    public function sessionCard()
    {
        return $this->belongsTo(SessionCard::class);
    }
}
