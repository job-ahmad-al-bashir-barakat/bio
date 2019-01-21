<?php

namespace Modules\Control\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaqType extends \Eloquent
{
    use SoftDeletes;

    protected $fillable = ['name_en','name_ar'];
}
