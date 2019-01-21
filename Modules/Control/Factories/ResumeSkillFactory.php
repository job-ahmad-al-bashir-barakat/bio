<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Illuminate\Validation\Rule;
use Modules\Control\Entities\ResumeSkill;

class ResumeSkillFactory extends GlobalFactory
{

    /**
     *  get datatable query
     */
    public function getDatatable($ResumeSkill, $request)
    {
        $query = ResumeSkill::where('resume_id','=',request()->get('resume'))->get();

        return $this->table
            ->queryConfig('resume-skill')
            ->queryDatatable($query)
            ->queryUpdateButton('id')
            ->queryDeleteButton('id')
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($ResumeSkill, $request)
    {
        return $this->table
            ->config('resume-skill',trans('control::app.skills'))
            ->addAutocomplete('autocomplete/skills',trans('control::app.skill'),'skill_id','skill.name','skill.name','req required d:tags','data-tags=true')
            ->addInputNumber(trans('control::app.ratio'),'proficiency_ratio','proficiency_ratio','req required','min=0 max=100')
            ->addHiddenInput('resume_id','resume_id',$request->get('resume'),false,true)
            ->addActionButton($this->update,'update','update')
            ->addActionButton($this->delete,'delete','delete')
            ->addNavButton()
            ->render();
    }

    /**
     *  store action for save relation
     */
    public function storeDatatable($aa = null, $request = null, $result = null)
    {
        $resumeSkill = ResumeSkill::where('resume_id','=',request('resume_id'))
            ->where('skill_id','=',request('skill_id'))
            ->get();

        if($resumeSkill->count())
            return response()->json([
                'skill_id' => 'dub',
            ],505);

        ResumeSkill::create(request()->input());
    }

    /**
     *  update action for update relation
     */
    public function updateDatatable($aa = null, $request = null, $result = null)
    {
        //
    }

    /**
     *  destroy action for destroy relation
     */
    public function destroyDatatable($aa = null, $request = null, $result = null)
    {
        //
    }

    /**
     *  inline validate dialog form
     */
    public function validateDatatable()
    {
        return [
            'skill_id'          => 'required',
            'proficiency_ratio' => 'required|numeric',
        ];
    }
}
