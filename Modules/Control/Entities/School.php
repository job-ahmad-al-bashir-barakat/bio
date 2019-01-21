<?php

namespace Modules\Control\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'user_id', 'approvied'];
}
