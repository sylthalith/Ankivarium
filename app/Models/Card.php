<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['front', 'back', 'interval', 'next_review_date', 'type'];

    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }

    public function sessionCard()
    {
        return $this->belongsTo(SessionCard::class);
    }
}
