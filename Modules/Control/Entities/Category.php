<?php

namespace Modules\Control\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['name_en', 'name_ar' ,'description_en' ,'description_ar','icon_id'];

    protected $with = ['icon'];

    function icon()
    {
        return $this->belongsTo(Icon::class);
    }
}
