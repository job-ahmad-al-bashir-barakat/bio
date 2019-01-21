<?php

namespace App\Traits;

use Modules\Control\Entities\Like;

trait Likes
{
    function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    function getLikeCountAttribute()
    {
        return $this->likes->count();
    }

    function getUserLikeCountAttribute()
    {
        return $this->likes->where('user_id','=',\Auth::id())->count();
    }
}