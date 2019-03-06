<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    public $timestamps = false;
    
    public function votable()
    {
        return $this->morphTo();
    }
}
