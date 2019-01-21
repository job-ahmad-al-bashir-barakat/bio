<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Modules\Control\Entities\ApplyStatus;

class ApplyStatusFactory extends GlobalFactory
{

    /**
     *  get datatable query
     */
    public function getDatatable($ApplyStatus, $request)
    {
        $query = ApplyStatus::all();

        return $this->table
            ->queryConfig('apply-status')
            ->queryDatatable($query)
            ->queryUpdateButton('id')
            ->queryDeleteButton('id')
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($ApplyStatus, $request)
    {
        return $this->table
            ->config('apply-status',trans('control::app.apply_status'))
            ->addInputText($this->name,'name','name','req required')
            ->addInputText(trans('control::app.code'),'code','code','req required')
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
            'code' => 'required',
        ];
    }
}
