<?php

namespace Modules\Control\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Degree extends Model
{
    use SoftDeletes;

    protected $fillable = ['name_en','name_ar'];
}
