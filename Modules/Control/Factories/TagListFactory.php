<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Modules\Control\Entities\TagList;

class TagListFactory extends GlobalFactory
{
    /**
     *  get datatable query
     */
    public function getDatatable($TagList, $request)
    {
        $query = TagList::where('approvied','=',true)->get();

        return $this->table
            ->queryConfig('tage-lists')
            ->queryDatatable($query)
            ->queryUpdateButton('id')
            ->queryDeleteButton('id')
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($TagList, $request)
    {
        return $this->table
            ->config('tage-lists',trans('control::app.tage_lists'))
            ->addInputText($this->name,'name','name','req required')
            ->addActionButton($this->update,'update','update')
            ->addActionButton($this->delete,'delete','delete')
            ->addNavButton()
            ->render();
    }

    /**
     *  store action for save relation
     */
    public function storeDatatable($TagList = null, $request = null, $result = null)
    {
        //
    }

    /**
     *  update action for update relation
     */
    public function updateDatatable($TagList = null, $request = null, $result = null)
    {
        //
    }

    /**
     *  destroy action for destroy relation
     */
    public function destroyDatatable($TagList = null, $request = null, $result = null)
    {
        //
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
