<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoachingSession extends Model
{
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function rating() {
        return $this->hasOne(SessionStar::class);
    }
}
