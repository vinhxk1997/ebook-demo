<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialUser extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'provider_user_id',
        'provider',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
