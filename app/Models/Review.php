<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deteted_at',
    ];

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable')->where('parent_id', 0);
    }

    public function story()
    {
        return $this->belongsTo('App\Models\Story', 'story_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function votes()
    {
        return $this->morphMany('App\Models\Vote', 'votable');
    }
}
