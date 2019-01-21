<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Modules\Control\Entities\WorkExpJobTitle;

class WorkExpJobTitleFactory extends GlobalFactory
{

    /**
     *  get datatable query
     */
    public function getDatatable($WorkExpJobTitle, $request)
    {
        $query = WorkExpJobTitle::where('approvied','=',true)->get();

        return $this->table
            ->queryConfig('work-experience-job-title')
            ->queryDatatable($query)
            ->queryUpdateButton('id')
            ->queryDeleteButton('id')
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($WorkExpJobTitle, $request)
    {
        return $this->table
            ->config('work-experience-job-title',trans('control::app.job_title'))
            ->addInputText($this->name,'name','name','req required')
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
            'name' => 'required',
        ];
    }
}
