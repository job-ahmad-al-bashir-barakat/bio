<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Modules\Control\Entities\HourlyRate;

class HourlyRateFactory extends GlobalFactory
{

    /**
     *  get datatable query
     */
    public function getDatatable($HourlyRate, $request)
    {
        $query = HourlyRate::all();

        return $this->table
            ->queryConfig('hourly-rates')
            ->queryDatatable($query)
            ->queryUpdateButton('id')
            ->queryDeleteButton('id')
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($HourlyRate, $request)
    {
        return $this->table
            ->config('hourly-rates',trans('control::app.hourly_rates'))
            ->addInputNumber(trans('control::app.min'),'rate_min','rate_min','req required')
            ->addInputNumber(trans('control::app.max'),'rate_max','rate_max','req required')
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
            'rate_min' => 'required|min:0',
            'rate_max' => 'required|min:0',
        ];
    }
}
