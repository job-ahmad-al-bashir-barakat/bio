<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Modules\Control\Entities\SocialNetwork;

class SocialNetworkFactory extends GlobalFactory
{

    /**
     *  get datatable query
     */
    public function getDatatable($SocialNetwork, $request)
    {
        $query = SocialNetwork::all();

        return $this->table
            ->queryConfig('social-networks')
            ->queryDatatable($query)
            ->queryUpdateButton('id')
            ->queryDeleteButton('id')
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($SocialNetwork, $request)
    {
        return $this->table
            ->config('social-networks',trans('control::app.social_networks'))
            ->addInputText($this->name,'name','name','req required')
            ->addInputText(trans('control::app.code'),'code','code','req required')
            ->addActionButton($this->update,'update','update')
            ->addActionButton($this->delete,'delete','delete')
            ->addNavButton()
            ->render();
    }

    /**
     *  store action for save relation
     */
    public function storeDatatable($SocialNetwork = null, $request = null, $result = null)
    {
        //
    }

    /**
     *  update action for update relation
     */
    public function updateDatatable($SocialNetwork = null, $request = null, $result = null)
    {
        //
    }

    /**
     *  destroy action for destroy relation
     */
    public function destroyDatatable($SocialNetwork = null, $request = null, $result = null)
    {
        //
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
