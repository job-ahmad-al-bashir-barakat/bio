<?php

namespace Modules\Control\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialNetwork extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'code'];
}
