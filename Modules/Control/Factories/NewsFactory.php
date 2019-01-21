<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Modules\Control\Entities\News;

class NewsFactory extends GlobalFactory
{

    /**
     *  get datatable query
     */
    public function getDatatable($News, $request)
    {
        $query = News::all();

        return $this->table
            ->queryConfig('news')
            ->queryDatatable($query)
            ->queryUpdateButton('id')
            ->queryDeleteButton('id')
            ->queryCustomButton('comment' ,'id' ,'fa fa-comment','','onclick="commentsModal(this)"')
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($News, $request)
    {
        return $this->table
            ->config('news',trans('control::app.news'))
            ->addInputText($this->name.$this->en,'title_en','title_en','req required')
            ->addInputText($this->name.$this->ar,'title_ar','title_ar','req required')
            ->addTextArea(trans('control::app.content').$this->en,'content_en','content_en','req required none',['rows' => '6'])
            ->addTextArea(trans('control::app.content').$this->ar,'content_ar','content_ar','req required none',['rows' => '6'])
            ->addHiddenInput('user_id' ,'user_id' ,\Auth::id(),false,true)
            ->addActionButton(trans('control::app.comments'),'comment','comment')
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
            'title_en'   => 'required',
            'title_ar'   => 'required',
            'content_en' => 'required',
            'content_ar' => 'required',
        ];
    }
}
