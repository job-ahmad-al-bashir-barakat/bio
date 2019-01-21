<?php

namespace Modules\Control\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApply extends \Eloquent
{
    use SoftDeletes;

    protected $dates = [
        'interview_date',
    ];

    protected $fillable = [
        'resume_id',
        'job_id',
        'subject',
        'message',
        'interview_date',
        'interview_location',
        'apply_status_id',
        'user_id',
    ];

    function setInterviewDateAttribute($value) {

        $this->attributes['interview_date'] = Carbon::parse($value);
    }

    function getInterviewDateAttribute($value) {

        return Carbon::parse($value)->format('m/d/Y h:i A');
    }

    function resume()
    {
        return $this->belongsTo(Resume::class);
    }

    function job()
    {
        return $this->belongsTo(Job::class);
    }

    function applyStatus()
    {
        return $this->belongsTo(ApplyStatus::class);
    }
}
