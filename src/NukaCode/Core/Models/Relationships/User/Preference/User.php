<?php namespace NukaCode\Core\Models\Relationships\User\Preference;

trait User {

    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function preference()
    {
        return $this->belongsTo('User_Preference', 'preference_id');
    }
} 