<?php

namespace Modules\Control\Entities;

use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    protected $fillable = ['code'];

    protected $appends = ['icon'];

    function getIconAttribute()
    {
        return "<i class='{$this->code}'> $this->code</i>";
    }
}
