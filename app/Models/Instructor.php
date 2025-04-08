<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Instructor extends Authenticatable
{
    protected $guard = 'instructor';

    public function getFullnameAttribute()
    {
        $middleInitial = $this->middle_name ? ' ' . strtoupper(substr($this->middle_name, 0, 1)) . '.' : '';

        return $this->first_name . $middleInitial . ' ' . $this->last_name;
    }

    public function sessions()
    {
        return $this->hasMany(CoachingSession::class);
    }

    public function notifications()
    {
        return $this->hasMany(InstructorNotification::class)->latest();
    }

    public function getStarsAttribute()
    {
        if ($this->sessions->count() === 0) {
            return null;
        }

        $stars = array();

        foreach ($this->sessions as $session) {
            $rating = $session->rating;
            if (!$rating) continue;

            array_push($stars, $rating->stars);
        }

        return collect($stars)->avg();
    }

    public function getAgeAttribute()
    {
        return \Carbon\Carbon::parse($this->birthdate)->age;
    }

    public static function getFeatured() {
        return self::query()->inRandomOrder()->limit(3)->get();
    }
}
