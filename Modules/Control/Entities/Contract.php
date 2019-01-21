<?php

namespace Modules\Control\Entities;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Eloquent
{
    use SoftDeletes;

    protected $fillable = ['name_en' ,'name_ar'];
}
