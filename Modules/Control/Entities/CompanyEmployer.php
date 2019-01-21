<?php

namespace Modules\Control\Entities;

use Illuminate\Database\Eloquent\Model;

class CompanyEmployer extends Model
{
    protected $fillable = ['min', 'max'];

    protected $appends = ['name'];

    function getNameAttribute() {

        return number_format($this->min) .' - '. number_format($this->max);
    }
}
