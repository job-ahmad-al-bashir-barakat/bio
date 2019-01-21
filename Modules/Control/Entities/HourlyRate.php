<?php

namespace Modules\Control\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HourlyRate extends Model
{
    use SoftDeletes;

    protected $fillable = ['rate_min','rate_max'];

    protected $appends = ['name','value'];

    function getNameAttribute()
    {
        $max = $this->rate_max ? " - \${$this->rate_max}" : "+";

        return "\${$this->rate_min}$max";
    }

    function getValueAttribute()
    {
        return "$this->rate_min,$this->rate_max";
    }
}
