<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Modules\Control\Entities\Degree;

class DegreeFactory extends GlobalFactory
{
    /**
     *  get datatable query
     */
    public function getDatatable($Degree, $request)
    {
        $query = Degree::all();

        return $this->table
            ->queryConfig('degrees')
            ->queryDatatable($query)
            ->queryUpdateButton('id')
            ->queryDeleteButton('id')
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($Degree, $request)
    {
        return $this->table
            ->config('degrees',trans('control::app.degrees'))
            ->addInputText($this->name.$this->en,'name_en','name_en','req required')
            ->addInputText($this->name.$this->ar,'name_ar','name_ar','req required')
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
            'name_en' => 'required',
            'name_ar' => 'required',
        ];
    }
}
