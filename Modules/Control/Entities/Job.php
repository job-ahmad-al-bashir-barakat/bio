<?php

namespace Modules\Control\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;

class Job extends Model
{
    use SoftDeletes ,CascadeSoftDeletes;

    protected $fillable = [
        'name',
        'short_description',
        'salary',
        'work_hour_num',
        'experience_num',
        'detail',
        'last_update',
        'category_id',
        'contract_id',
        'company_id',
        'is_filled',
        'job_status'
    ];

    protected $dates = [
        'last_update'
    ];

    protected $with = [
        'category',
        'contract',
        'degree',
    ];

    protected $appends = ['job_status_title'];

    protected $cascadeDeletes = ['JobApply'];

    protected static function boot() {

        parent::boot();

        //before delete() method call this
        static::deleting(function($job) {

            $job->degree()->sync([]);
        });
    }

    function getJobStatusTitleAttribute()
    {
        $jobStatusTitle = [
            'c' => trans('control::app.closed'),
            'w' => trans('control::app.waiting')
        ];

        return $jobStatusTitle[$this->job_status];
    }

    function JobApply()
    {
        return $this->hasMany(JobApply::class);
    }

    function HasJobApply()
    {
        return $this->hasMany(JobApply::class)->where('user_id','=',\Auth::id());
    }

    function company()
    {
        return $this->belongsTo(Company::class);
    }

    function category()
    {
        return $this->belongsTo(Category::class);
    }

    function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    function degree()
    {
        return $this->belongsToMany(Degree::class);
    }
}
