<?php

namespace Modules\Control\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['text' ,'commentable_id' ,'commentable_type','date', 'user_id'];

    public $timestamps = false;

    protected $with = ['user'];

    protected $dates = ['date'];

    function user()
    {
        return $this->belongsTo(User::class);
    }
}
