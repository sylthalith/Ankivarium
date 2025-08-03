<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeckDailyStat extends Model
{
    protected $fillable = ['cards_due', 'cards_completed'];

    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }
}
