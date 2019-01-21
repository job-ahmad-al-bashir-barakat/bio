<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Carbon\Carbon;
use Modules\Control\Entities\Contact;
use Modules\Control\Entities\Resume;
use Modules\Control\Entities\SocialNetwork;

class ResumeFactory extends GlobalFactory
{

    /**
     *  get datatable query
     */
    public function getDatatable($Resume, $request)
    {
        $query = Resume::where('user_id','=',\Auth::id())->get();

        return $this->table
            ->queryConfig('datatable-resumes')
            ->queryDatatable($query)
            ->queryUpdateButton('id')
            ->queryDeleteButton('id')
            ->queryAddColumn('is_visible_label',function ($item) {
                return $item->is_visible ? trans('control::app.yes') : trans('control::app.no');
            })
            ->queryAddColumn('is_visible_icon',function ($item) {
                $is_visible = $item->is_visible  ? "fa fa-eye" : "fa fa-eye-slash";
                return "<span><i class='{$is_visible}'></i></span>";
            })
            ->queryMultiAutocompleteTemplete('tag_list_temp','tagList','name')
            ->queryCustomButton('logo','id','fa fa-image','','onclick="showFileUploadModal(this)"')
            ->queryCustomButton('educations','id','fa fa-book','',"href='javascript:void(0);' onclick='educationsModal(this)'")
            ->queryCustomButton('work_experiences','id','fa fa fa-briefcase','',"href='javascript:void(0);' onclick='workExperiencesModal(this)'")
            ->queryCustomButton('skills','id','fa fa-paint-brush','',"href='javascript:void(0);' onclick='skillsModal(this)'")
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($Resume, $request)
    {
        $socialNetworks = SocialNetwork::all();

        $table = $this->table
            ->config('datatable-resumes',trans('control::app.resumes'),['withTab' => true,'dialogWidth' => '60%'])
            ->startTab(trans('control::app.info'),'fa fa-info fa-2x')
                ->addInputText($this->name,'name','name','req required')
                ->addInputText(trans('control::app.headline'),'headline','headline','req required none')
                ->addTextArea(trans('control::app.short_description'),'short_description','short_description','req required none','rows=4')
                ->addInputNumber(trans('control::app.age'),'age','age','req required','min=0 max=100')
                ->setPlaceholder(trans('control::app.salary_per_hour'))
                ->addInputNumber(trans('control::app.salary'),'salary','salary','req required','min=0')
                ->addHiddenInput('last_update','last_update',Carbon::now()->toDateString(),false,true)
                ->addHiddenInput('user_id', 'user_id',\Auth::id(),false,true)
                ->startRelation('tag_list')
                    ->addMultiAutocomplete('autocomplete/tag-lists','tag_list_temp',trans('control::app.tag_lists'),'tag_list.id','tag_list.name','tag_list.name','req required d:tags none','data-tags=true')
                ->endRelation()
                ->addSelect([1 => ['title' => trans('control::app.yes') ,'selected'=> true ] ,0 => trans('control::app.no') ],trans('control::app.visible'),'is_visible','is_visible_label','is_visible_label','required req','','',false)
            ->endTab()
            ->startTab(trans('control::app.contacts'),'fa fa-phone fa-2x')
                ->startRelation('contact')
                    ->addInputEmail(trans('control::app.email'),'contact.email' ,'email','none req required')
                    ->addInputUrl(trans('control::app.website'),'contact.website' ,'website','none req required')
                    ->addInputText(trans('control::app.geolocation'),'contact.geolocation_title.'.$this->lang,'contact.geolocation_search','d:geolocation','disabled')
                    ->addInputGroup(trans('control::app.location'),'contact.location' ,'location','req required none','fa fa-map-marker','input-location hand',['data-modal' => '#modal-resumes-input-location','readonly'])
                    ->addInputText(trans('control::app.phone_number'),'contact.phone_number' ,'phone_number','req required',['data-masked' ,'data-mask-type' => 'mobile'])
                ->endRelation()
            ->endTab()
            ->startTab(trans('control::app.social_networks'),'fa fa-facebook fa-2x');

                foreach ($socialNetworks as $socialNetwork)
                    $table = $table->startRelation('contact[social]['.$socialNetwork->id.']')
                        ->setDefaultValue('#')
                        ->addInputText($socialNetwork->name,'contact.social.'.$socialNetwork->code.'.pivot.value' ,'contact.social.'.$socialNetwork->code.'.pivot.value','none')
                        ->endRelation();

            $table = $table->endTab()
            ->addActionButton(trans('control::app.visible') ,'is_visible_icon' ,'is_visible_icon')
            ->addActionButton(trans('control::app.educations'),'educations','educations','center all','60px')
            ->addActionButton(trans('control::app.work_experiences'),'work_experiences','work_experiences','center all','60px')
            ->addActionButton(trans('control::app.skills'),'skills','skills','center all','60px')
            ->addActionButton(trans('control::app.image_profile'),'logo','logo')
            ->addActionButton($this->update,'update','update')
            ->addActionButton($this->delete,'delete','delete')
            ->addNavButton()
            ->render();

        return $table;
    }

    /**
     *  store action for save relation
     */
    public function storeDatatable($Resume = null, $request = null, $result = null)
    {
        $geolocation = geolocation($request->input('contact.location'));

        $contact = Contact::create(array_merge($request->input('contact') ,[
            'geolocation_title'  => $geolocation['geolocationTitle'],
            'geolocation_search' => $geolocation['geolocationSearch'],
        ]));

        $contact->socialNetwork()->sync($request->input('contact.social'));

        $resume = Resume::create(array_merge($request->input(),['contact_id' => $contact->id]));

        $resume->tagList()->sync($request->input('tag_list.id'));
    }

    /**
     *  update action for update relation
     */
    public function updateDatatable($Resume = null, $request = null, $result = null)
    {
        $geolocation = geolocation($request->input('contact.location'));

        $result->contact()->update(array_merge($request->input('contact') ,[
            'geolocation_title'  => $geolocation['geolocationTitle'],
            'geolocation_search' => $geolocation['geolocationSearch'],
        ]));

        $result->contact->socialNetwork()->sync($request->input('contact.social'));

        $result->tagList()->sync($request->input('tag_list.id'));
    }

    /**
     *  inline validate dialog form
     */
    public function validateDatatable()
    {
        return [
            'name'                 => 'required',
            'headline'             => 'required',
            'short_description'    => 'required|min:150',
            'age'                  => 'required|numeric|min:0',
            'salary'               => 'required|numeric|min:0',
            'is_visible'           => 'required',
            'tag_list.id'          => 'required',
            'contact.email'        => 'required|email',
            'contact.website'      => 'required|url',
            'contact.location'     => 'required',
            'contact.phone_number' => 'required',
        ];
    }
}
