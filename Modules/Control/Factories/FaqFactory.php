<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Modules\Control\Entities\Faq;

class FaqFactory extends GlobalFactory
{

    /**
     *  get datatable query
     */
    public function getDatatable($Faq, $request)
    {
        $query = Faq::all();

        return $this->table
            ->queryConfig('faqs')
            ->queryDatatable($query)
            ->queryUpdateButton('id')
            ->queryDeleteButton('id')
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($Faq, $request)
    {
        return $this->table
            ->config('faqs',trans('control::app.faqs'))
            ->addAutocomplete('autocomplete/faq-types',trans('control::app.faq_type'),'faq_type_id',lang('faq_type.name'),lang('faq_type.name'),'req required')
            ->addInputText(trans('control::app.title').$this->en,'title_en','title_en','req required')
            ->addInputText(trans('control::app.title').$this->ar,'title_ar','title_ar','req required')
            ->addTextArea(trans('control::app.content').$this->en,'content_en','content_en','req required none')
            ->addTextArea(trans('control::app.content').$this->ar,'content_ar','content_ar','req required none')
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
            'faq_type_id' => 'required',
            'title_en'    => 'required',
            'title_ar'    => 'required',
            'content_en'  => 'required',
            'content_ar'  => 'required',
        ];
    }
}
