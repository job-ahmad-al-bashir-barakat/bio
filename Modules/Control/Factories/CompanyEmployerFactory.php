<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Modules\Control\Entities\CompanyEmployer;

class CompanyEmployerFactory extends GlobalFactory
{

    /**
     *  get datatable query
     */
    public function getDatatable($CompanyEmployer, $request)
    {
        $query = CompanyEmployer::all();

        return $this->table
            ->queryConfig('company-employers')
            ->queryDatatable($query)
            ->queryUpdateButton('id')
            ->queryDeleteButton('id')
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($CompanyEmployer, $request)
    {
        return $this->table
            ->config('company-employers',trans('control::app.company_employers'))
            ->addInputNumber(trans('control::app.min'),'min','min','req required')
            ->addInputNumber(trans('control::app.max'),'max','max','req required')
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
            'min' => 'required|min:0',
            'max' => 'required|min:0',
        ];
    }
}
