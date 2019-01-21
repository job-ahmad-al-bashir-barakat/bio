<?php

namespace Modules\Control\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResumeEducation extends Model
{
    use SoftDeletes;

    protected $table = 'resume_education';

    protected $fillable = [
        'degree_id',
        'majer_id',
        'school_id',
        'date_from',
        'date_to',
        'short_description',
        'resume_id',
    ];

    protected $with = ['degree','majer','school'];

    protected $dates = ['date_from_to', 'date_from' ,'date_to'];

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

    function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    function majer()
    {
        return $this->belongsTo(Majer::class);
    }

    function school()
    {
        return $this->belongsTo(School::class);
    }
}
