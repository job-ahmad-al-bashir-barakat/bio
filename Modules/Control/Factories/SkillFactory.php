<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Modules\Control\Entities\Skill;

class SkillFactory extends GlobalFactory
{

    /**
     *  get datatable query
     */
    public function getDatatable($Skill, $request)
    {
        $query = Skill::where('approvied','=',true)->get();

        return $this->table
            ->queryConfig('skills')
            ->queryDatatable($query)
            ->queryUpdateButton('id')
            ->queryDeleteButton('id')
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($Skill, $request)
    {
        return $this->table
            ->config('skills',trans('control::app.skills'))
            ->addInputText($this->name,'name','name','req required')
            ->addActionButton($this->update,'update','update')
            ->addActionButton($this->delete,'delete','delete')
            ->addNavButton()
            ->render();
    }

    /**
     *  store action for save relation
     */
    public function storeDatatable($Skill = null, $request = null, $result = null)
    {
        //
    }

    /**
     *  update action for update relation
     */
    public function updateDatatable($Skill = null, $request = null, $result = null)
    {
        //
    }

    /**
     *  destroy action for destroy relation
     */
    public function destroyDatatable($Skill = null, $request = null, $result = null)
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
