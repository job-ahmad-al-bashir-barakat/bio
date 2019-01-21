<?php

namespace Modules\Control\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use App\Traits\Likes;
use App\User;

class News extends \Eloquent
{
    use SoftDeletes , CascadeSoftDeletes, Likes;

    protected $fillable = ['title_en', 'title_ar', 'content_en', 'content_ar', 'user_id'];

    protected $appends = ['like_count' ,'user_like_count'];

    protected $dates = ['date'];

    protected $with = ['user','likes'];

    protected $cascadeDeletes = ['likes' ,'comments'];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
