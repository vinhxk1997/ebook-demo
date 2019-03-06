<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;

class Story extends Model
{
    use SoftDeletes, CascadeSoftDeletes;


    protected $guarded = ['id'];

    protected $cascadeDeletes = ['chapters'];

    protected $casts = [
        'is_mature' => 'boolean',
        'status' => 'boolean',
        'is_completed' => 'boolean',
        'is_recommended' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deteted_at',
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Models\Meta', 'meta_story', 'story_id', 'meta_id')
            ->where('type', 'category');
    }

    public function chapters()
    {
        return $this->hasMany('App\Models\Chapter', 'story_id');
    }

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'object')->where('parent_id', 0);
    }

    public function metas()
    {
        return $this->belongsToMany('App\Models\Meta', 'meta_story', 'story_id', 'meta_id');
    }

    public function reports()
    {
        return $this->hasMany('App\Models\Report', 'story_id');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review', 'story_id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Meta', 'meta_story', 'story_id', 'meta_id')
            ->where('type', 'tag');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
