<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionCard extends Model
{
    protected $fillable = ['is_done'];

    public function studySession()
    {
        return $this->belongsTo(StudySession::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
