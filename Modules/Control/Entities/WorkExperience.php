<?php

namespace Modules\Control\Entities;

use Carbon\Carbon;
use Faker\Provider\DateTime;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Aut\FileUpload\Entities\Image;

class WorkExperience extends Model
{
    use SoftDeletes ,CascadeSoftDeletes;

    protected $table = 'work_experience';

    protected $with = ['workExpJobTitle','workExpCompany','image'];

    protected $dates = ['date_from_to' ,'date_from' ,'date_to'];

    protected $fillable = ['work_exp_job_title_id','work_exp_company_id','image_id','summery','date_from','date_to','resume_id'];

    protected $cascadeDeletes = ['image'];

    function setDateFromAttribute($value) {

        $this->attributes['date_from'] = Carbon::createFromDate($value)->format('Y-m-d');
    }

    function setDateToAttribute($value) {

        $this->attributes['date_to'] = Carbon::createFromDate($value)->format('Y-m-d');
    }

    function getDateFromAttribute($value) {

        return Carbon::parse($value)->year;
    }

    function getDateToAttribute($value) {

        return Carbon::parse($value)->year;
    }

    function getDateFromToAttribute($value) {

        return "{$this->date_from} - {$this->date_to}";
    }

    function workExpJobTitle()
    {
        return $this->belongsTo(WorkExpJobTitle::class);
    }

    function workExpCompany()
    {
        return $this->belongsTo(WorkExpCompany::class);
    }

    function image()
    {
        return $this->belongsTo(Image::class);
    }

}
