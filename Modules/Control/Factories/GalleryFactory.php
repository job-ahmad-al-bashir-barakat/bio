<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Modules\Control\Entities\Gallery;

class GalleryFactory extends GlobalFactory
{
    /**
     *  get datatable query
     */
    public function getDatatable($Gallery, $request)
    {
        $query = Gallery::where('user_id','=',\Auth::id())->get();

        return $this->table
            ->queryConfig('datatable-gallery')
            ->queryDatatable($query)
            ->queryUpdateButton('id')
            ->queryDeleteButton('id')
            ->queryCustomButton('comment' ,'id' ,'fa fa-comment')
            ->queryCustomButton('image_gallery','id','fa fa-image','','onclick="galleryModal(this)"')
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($Gallery, $request)
    {
        return $this->table
            ->config('datatable-gallery',trans('control::app.galleries'))
            ->addInputText(trans('control::app.title'),'title','title','req required')
            ->addTextArea(trans('control::app.short_description'),'short_description','short_description','req required none','rows=8')
            ->addHiddenInput('user_id', 'user_id',\Auth::id(),false,true)
            ->addActionButton(trans('control::app.comments'),'comment','comment')
            ->addActionButton(trans('control::app.image'),'image_gallery','image_gallery')
            ->addActionButton($this->update,'update' ,'update')
            ->addActionButton($this->delete,'delete' ,'delete')
            ->addNavButton()
            ->render();
    }

    /**
     *  inline validate dialog form
     */
    public function validateDatatable()
    {
        return [
            'title'             => 'required',
            'short_description' => 'required',
        ];
    }
}
