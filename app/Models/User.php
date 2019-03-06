<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Iatstuti\Database\Support\CascadeSoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, CascadeSoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'login_name',
        'email',
        'password',
    ];

    protected $cascadeDeletes = [
        'stories',
        'comments',
        'reportings',
        'reviewings',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $guarded = ['id'];

    protected $dates = [
        'email_verified_at',
        'created_at',
        'updated_at',
        'deteted_at',
    ];

    protected $casts = [
        'is_banned' => 'boolean',
    ];

    public function archives()
    {
        return $this->belongsToMany('App\Models\Story', 'archives', 'user_id', 'story_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'user_id');
    }

    public function followers()
    {
        return $this->belongsToMany('App\Models\User', 'follows', 'following_user_id', 'followed_user_id');
    }
    
    public function followings()
    {
        return $this->belongsToMany('App\Models\User', 'follows', 'followed_user_id', 'following_user_id');
    }

    public function saveLists()
    {
        return $this->hasMany('App\Models\SaveList', 'user_id');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notifications', 'user_id');
    }

    public function profile()
    {
        return $this->hasOne('App\Models\UserProfile', 'user_id');
    }

    public function profilePosts()
    {
        return $this->morphMany('App\Models\Comment', 'commentable')->where('parent_id', 0);
    }

    public function reportings()
    {
        return $this->hasMany('App\Models\Report', 'user_id');
    }

    public function reviewings()
    {
        return $this->hasMany('App\Models\Review', 'user_id');
    }

    public function stories()
    {
        return $this->hasMany('App\Models\Story', 'user_id');
    }

    public function votings()
    {
        return $this->hasMany('App\Models\Vote', 'user_id');
    }
}
