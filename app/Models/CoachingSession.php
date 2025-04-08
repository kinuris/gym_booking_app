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

    public function rating()
    {
        return $this->hasOne(SessionStar::class);
    }

    public function events()
    {
        return $this->hasMany(SessionEvent::class);
    }

    public function progressRecords()
    {
        return $this->hasMany(ProgressRecord::class);
    }

    public function getDurationAttribute()
    {
        $start = new \DateTime($this->start_date);
        $end = new \DateTime($this->end_date);
        $interval = $start->diff($end);

        return $interval->days;
    }
}
