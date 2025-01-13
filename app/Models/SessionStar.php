<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionStar extends Model
{
    public function session() {
        return $this->belongsTo(CoachingSession::class);
    }
}
