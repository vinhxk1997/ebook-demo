<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;

    public function stories()
    {
        return $this->belongsToMany('App\Models\Story', 'meta_story', 'meta_id', 'story_id');
    }

    public function publishedStories()
    {
        return $this->stories()->published();   
    }
}
