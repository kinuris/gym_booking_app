<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    protected $guard = 'client';

    public function sessions()
    {
        return $this->hasMany(CoachingSession::class);
    }

    public function notifications()
    {
        return $this->hasMany(ClientNotification::class)->latest();
    }

    public function getFullnameAttribute()
    {
        $middleInitial = $this->middle_name ? ' ' . strtoupper(substr($this->middle_name, 0, 1)) . '.' : '';

        return $this->first_name . $middleInitial . ' ' . $this->last_name;
    }
}
