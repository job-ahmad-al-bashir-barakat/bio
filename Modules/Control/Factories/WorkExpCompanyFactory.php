<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Modules\Control\Entities\WorkExpCompany;

class WorkExpCompanyFactory extends GlobalFactory
{

    /**
     *  get datatable query
     */
    public function getDatatable($WorkExpCompany, $request)
    {
        $query = WorkExpCompany::where('approvied','=',true)->get();

        return $this->table
            ->queryConfig('work-experience-companies')
            ->queryDatatable($query)
            ->queryUpdateButton('id')
            ->queryDeleteButton('id')
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($WorkExpCompany, $request)
    {
        return $this->table
            ->config('work-experience-companies',trans('control::app.work_experience_companies'))
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
