<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Modules\Control\Entities\ResumeEducation;

class ResumeEducationFactory extends GlobalFactory
{

    /**
     *  get datatable query
     */
    public function getDatatable($ResumeEducation, $request)
    {
        $query = ResumeEducation::where('resume_id','=',request()->get('resume'))->get();

        return $this->table
            ->queryConfig('datatable-resume-educations')
            ->queryDatatable($query)
            ->queryUpdateButton('id')
            ->queryDeleteButton('id')
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($ResumeEducation, $request)
    {
        return $this->table
            ->config('datatable-resume-educations',trans('control::app.educations'))
            ->addAutocomplete('autocomplete/degree',trans('control::app.degree'),'degree_id',lang('degree.name'),lang('degree.name'),'req required')
            ->addAutocomplete('autocomplete/majer',trans('control::app.majer'),'majer_id','majer.name','majer.name','req required d:tags','data-tags=true')
            ->addAutocomplete('autocomplete/school',trans('control::app.school'),'school_id','school.name','school.name','req required d:tags','data-tags=true')
            ->addTextArea(trans('control::app.short_description'),'short_description','short_description','req required none','rows=4')
            ->addInputGroup(trans('control::app.date_from'),'date_from','date_from','req required','fa fa-calendar','date','data-format=YYYY')
            ->addInputGroup(trans('control::app.date_to'),'date_to','date_to','req required','fa fa-calendar','date','data-format=YYYY')
            ->addHiddenInput('resume_id','resume_id',$request->get('resume'),false,true)
            ->addActionButton($this->update,'update','update')
            ->addActionButton($this->delete,'delete','delete')
            ->addNavButton()
            ->render();
    }

    /**
     *  inline validate dialog form
     */
    public function validateDatatable()
    {
        return [
            'degree_id'         => 'required',
            'majer_id'          => 'required',
            'school_id'         => 'required',
            'short_description' => 'required:min:150',
            'date_from'         => 'required',
            'date_to'           => 'required',
        ];
    }
}
