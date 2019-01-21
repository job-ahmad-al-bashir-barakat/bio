<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Modules\Control\Entities\School;

class SchoolFactory extends GlobalFactory
{

    /**
     *  get datatable query
     */
    public function getDatatable($School, $request)
    {
        $query = School::where('approvied','=',true)->get();

        return $this->table
            ->queryConfig('schools')
            ->queryDatatable($query)
            ->queryUpdateButton('id')
            ->queryDeleteButton('id')
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($School, $request)
    {
        return $this->table
            ->config('schools',trans('control::app.schools'))
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
            'name' => 'required'
        ];
    }
}
