<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionEvent extends Model
{
    public function session()
    {
        return $this->belongsTo(CoachingSession::class, 'coaching_session_id');
    }
}
