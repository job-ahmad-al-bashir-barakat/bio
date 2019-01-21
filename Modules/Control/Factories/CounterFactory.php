<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Modules\Control\Entities\Counter;

class CounterFactory extends GlobalFactory
{

    /**
     *  get datatable query
     */
    public function getDatatable($Counter, $request)
    {
        $query = Counter::all();

        return $this->table
            ->queryConfig('counters')
            ->queryDatatable($query)
            ->queryUpdateButton('id')
            ->queryDeleteButton('id')
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($Counter, $request)
    {
        return $this->table
            ->config('counters',trans('control::app.counters'))
            ->addInputText(trans('control::app.title'),'title','title','req required')
            ->addInputNumber(trans('control::app.number'),'number','number','req required')
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
            'title'  => 'required',
            'number' => 'required',
        ];
    }
}
