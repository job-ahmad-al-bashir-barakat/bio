<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Modules\Control\Entities\Category;

class CategoryFactory extends GlobalFactory
{

    /**
     *  get datatable query
     */
    public function getDatatable($Category, $request)
    {
        $query = Category::with(['icon'])->get();

        return $this->table
            ->queryConfig('category')
            ->queryDatatable($query)
            ->queryUpdateButton('id')
            ->queryDeleteButton('id')
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($Category, $request)
    {
        return $this->table
            ->config('category',trans('control::app.category'))
            ->addInputText($this->name.$this->en,'name_en','name_en','req required')
            ->addInputText($this->name.$this->ar,'name_ar','name_ar','req required')
            ->addTextArea($this->description.$this->ar,'description_en','description_en','req required')
            ->addTextArea($this->description.$this->ar,'description_ar','description_ar','req required')
            ->addAutocomplete('autocomplete/icon',trans('control::app.icon'),'icon_id','icon.code','icon.icon','req required')
            ->addActionButton($this->update,'update','update')
            ->addActionButton($this->delete,'delete','delete')
            ->addNavButton()
            ->render();
    }

    /**
     *  store action for save relation
     */
    public function storeDatatable($Category = null, $request = null, $result = null)
    {
        //
    }

    /**
     *  update action for update relation
     */
    public function updateDatatable($Category = null, $request = null, $result = null)
    {
        //
    }

    /**
     *  destroy action for destroy relation
     */
    public function destroyDatatable($Category = null, $request = null, $result = null)
    {
        //
    }

    /**
     *  inline validate dialog form
     */
    public function validateDatatable()
    {
        return [
            'name_en'        => 'required',
            'name_ar'        => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'icon_id'        => 'required',
        ];
    }
}
