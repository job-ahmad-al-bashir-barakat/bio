<?php

namespace Modules\Control\Entities;

use Illuminate\Database\Eloquent\Model;

class Like extends \Eloquent
{
    protected $fillable = ['user_id' ,'likeable_type' ,'likeable_id'];

    public $timestamps = false;

    function likeble()
    {
        return $this->morphTo();
    }
}
