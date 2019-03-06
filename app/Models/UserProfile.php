<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'address',
        'about',
    ];

    protected $primaryKey = 'user_id';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
