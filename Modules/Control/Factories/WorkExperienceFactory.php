<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Modules\Control\Entities\WorkExperience;

class WorkExperienceFactory extends GlobalFactory
{

    /**
     *  get datatable query
     */
    public function getDatatable($WorkExperience, $request)
    {
        $query = WorkExperience::where('resume_id','=',request()->get('resume'))->get();

        return $this->table
            ->queryConfig('datatable-work-experiences')
            ->queryDatatable($query)
            ->queryUpdateButton('id')
            ->queryDeleteButton('id')
            ->queryCustomButton('logo','id','fa fa-image','','onclick="showWorkExperienceFileUploadModal(this)"')
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($WorkExperience, $request)
    {
        return $this->table
            ->config('datatable-work-experiences',trans('control::app.work_experiences'),['dialogWidth' => '70%'])
            ->addAutocomplete('autocomplete/we-company',trans('control::app.company'),'work_exp_company_id','work_exp_company.name','work_exp_company.name','req required d:tags','data-tags=true')
            ->addAutocomplete('autocomplete/we-job-title',trans('control::app.job_title'),'work_exp_job_title_id','work_exp_job_title.name','work_exp_job_title.name','req required d:tags','data-tags=true')
            ->addTextArea(trans('control::app.summery'),'summery','summery','req required d:summernote-editor none','rows=4')
            ->addInputGroup(trans('control::app.date_from'),'date_from','date_from','req required','fa fa-calendar','date','data-format=YYYY')
            ->addInputGroup(trans('control::app.date_to'),'date_to','date_to','req required','fa fa-calendar','date','data-format=YYYY')
            ->addHiddenInput('resume_id','resume_id',$request->get('resume'),false,true)
            ->addActionButton(trans('control::app.logo'),'logo','logo')
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
            'work_exp_company_id'   => 'required',
            'work_exp_job_title_id' => 'required',
            'summery'               => 'required',
            'date_from'             => 'required',
            'date_to'               => 'required',
        ];
    }
}
