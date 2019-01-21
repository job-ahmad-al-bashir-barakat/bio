<?php

namespace Modules\Control\Entities;

use Aut\FileUpload\Entities\Image;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletes;
use willvincent\Rateable\Rateable;
use App\Traits\Likes;
use Carbon\Carbon;
use Eloquent;

class Company extends Eloquent
{
    use SoftDeletes, Rateable, Likes ,CascadeSoftDeletes;

    protected $fillable = [
        'name',
        'headline',
        'short_description',
        'detail',
        'founded_from',
        'image_id',
        'user_id',
        'contact_id',
        'company_employer_id'
    ];

    protected $dates = ['founded_from'];

    protected $with = ['contact.socialNetwork','companyEmployer','image','likes'];

    protected $appends = ['job_count','like_count' ,'user_like_count'];

    protected $cascadeDeletes = ['jobs' ,'contact' ,'image'];

    function setFoundedFromAttribute($value) {

        $this->attributes['founded_from'] = Carbon::createFromDate($value)->format('Y-m-d');
    }

    function getFoundedFromAttribute($value) {

        return Carbon::parse($value)->year;
    }

    function image()
    {
        return $this->belongsTo(Image::class);
    }

    function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    function jobs()
    {
        return $this->hasMany(Job::class);
    }

    function companyEmployer()
    {
        return $this->belongsTo(CompanyEmployer::class);
    }

    function getJobCountAttribute()
    {
        return $this->jobs->where('job_status','w')->count();
    }
}
