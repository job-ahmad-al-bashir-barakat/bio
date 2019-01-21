<?php

namespace Modules\Control\Entities;

use Aut\FileUpload\Entities\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;

class Resume extends \Eloquent
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'name',
        'headline',
        'short_description',
        'age',
        'salary',
        'last_update',
        'image_id',
        'user_id',
        'contact_id',
        'is_visible'
    ];

    protected $dates = ['last_update'];

    protected $with = ['contact.socialNetwork','image','tagList'];

    protected $cascadeDeletes = ['contact' ,'resumeEducation' ,'workExperience' ,'image' ,'JobApply'];

    protected static function boot() {

        parent::boot();

        //before delete() method call this
        static::deleting(function($resume) {

            $resume->tagList()->sync([]);
            $resume->skills()->sync([]);
        });
    }

    function JobApply()
    {
        return $this->hasMany(JobApply::class);
    }

    function HasJobApply()
    {
        return $this->hasMany(JobApply::class)->where('user_id','=',\Auth::id());
    }

    function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    function image()
    {
        return $this->belongsTo(Image::class);
    }

    function tagList()
    {
        return $this->belongsToMany(TagList::class);
    }

    function resumeEducation()
    {
        return $this->hasMany(ResumeEducation::class);
    }

    function workExperience()
    {
        return $this->hasMany(WorkExperience::class);
    }

    function skills()
    {
        return $this->belongsToMany(Skill::class)->withPivot(['proficiency_ratio']);
    }
}
