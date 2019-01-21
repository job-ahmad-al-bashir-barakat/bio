<?php

namespace Modules\Control\Entities;

use Illuminate\Database\Eloquent\Model;

class ResumeSkill extends \Eloquent
{
    protected $table = 'resume_skill';

    protected $fillable = ['resume_id','skill_id','proficiency_ratio'];

    protected $with = ['skill'];

    public $timestamps = false;

    function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
