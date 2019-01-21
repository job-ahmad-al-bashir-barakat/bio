<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Modules\Control\Entities\Majer;

class MajerFactory extends GlobalFactory
{

    /**
     *  get datatable query
     */
    public function getDatatable($Majer, $request)
    {
        $query = Majer::where('approvied','=',true)->get();

        return $this->table
            ->queryConfig('majers')
            ->queryDatatable($query)
            ->queryUpdateButton('id')
            ->queryDeleteButton('id')
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($Majer, $request)
    {
        return $this->table
            ->config('majers',trans('control::app.majers'))
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
