<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaveList extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    public function stories()
    {
        return $this->belongsToMany('App\Models\Story', 'list_story', 'list_id', 'story_id');
    }

    public function publishedStories()
    {
        return $this->stories()->published();   
    }
}
