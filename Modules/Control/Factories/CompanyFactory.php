<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Modules\Control\Entities\Company;
use Modules\Control\Entities\Contact;
use Modules\Control\Entities\SocialNetwork;

class CompanyFactory extends GlobalFactory
{

    /**
     *  get datatable query
     */
    public function getDatatable($Company, $request)
    {
        $query = Company::with(['jobs'])->where('user_id','=',\Auth::id())->get();

        return $this->table
            ->queryConfig('datatable-companies')
            ->queryDatatable($query)
            ->queryUpdateButton('id')
            ->queryDeleteButton('id')
            ->queryCustomButton('logo','id','fa fa-image','','onclick="showFileUploadModal(this)"')
            ->queryCustomButton('jobs','id','fa fa-briefcase','',"href='javascript:void(0);' onclick='jobsModal(this)'")
            ->queryAddColumn('jobs_num',function ($item) {
                return "<lable class='label label-primary'>{$item->job_count} jobs</lable>";
            })
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($Company, $request)
    {
        $socialNetworks = SocialNetwork::all();

        $table = $this->table
            ->config('datatable-companies',trans('control::app.companies'),['withTab' => true,'dialogWidth' => '60%'])
            ->startTab(trans('control::app.info'),'fa fa-info fa-2x')
                ->addInputText($this->name,'name','name','req required')
                ->addHiddenInput('user_id', 'user_id',\Auth::id(),false,true)
                ->addInputText(trans('control::app.headline'),'headline','headline','req required none')
                ->addAutocomplete('autocomplete/company-employers',trans('control::app.company_employer') ,'company_employer_id', 'company_employer.min','company_employer.name','req required none')
                ->addTextArea(trans('control::app.short_description'),'short_description','short_description','req required none','rows=4')
                ->addTextArea(trans('control::app.detail'),'detail','detail','req required d:summernote-editor none','rows=8')
                ->setPlaceholder('ex Founded on, 2013')
                ->addInputGroup(trans('control::app.founded_from'),'founded_from','founded_from','req required','fa fa-calendar','date','data-format=YYYY')
            ->endTab()
            ->startTab(trans('control::app.contacts'),'fa fa-phone fa-2x')
                ->startRelation('contact')
                    ->addInputEmail(trans('control::app.email'),'contact.email' ,'email','none req required')
                    ->addInputUrl(trans('control::app.website'),'contact.website' ,'website','none req required')
                    ->addInputText(trans('control::app.geolocation'),'contact.geolocation_title.'.$this->lang,'contact.geolocation_search','d:geolocation','disabled')
                    ->addInputGroup(trans('control::app.location'),'contact.location' ,'location','req required none','fa fa-map-marker','input-location hand',['data-modal' => '#modal-companies-input-location','readonly'])
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
            ->addActionButton(trans('control::app.jobs_count'),'jobs_num','jobs_num')
            ->addActionButton(trans('control::app.jobs'),'jobs','jobs')
            ->addActionButton(trans('control::app.logo'),'logo','logo')
            ->addActionButton($this->update,'update','update')
            ->addActionButton($this->delete,'delete','delete')
            ->addNavButton()
            ->render();

            return $table;
    }

    /**
     *  store action for save relation
     */
    public function storeDatatable($Company = null, $request = null, $result = null)
    {
        $geolocation = geolocation($request->input('contact.location'));

        $contact = Contact::create(array_merge($request->input('contact') ,[
            'geolocation_title'  => $geolocation['geolocationTitle'],
            'geolocation_search' => $geolocation['geolocationSearch'],
        ]));

        $contact->socialNetwork()->sync($request->input('contact.social'));

        Company::create(array_merge($request->input(),['contact_id' => $contact->id]));
    }

    /**
     *  update action for update relation
     */
    public function updateDatatable($Company = null, $request = null, $result = null)
    {
        $geolocation = geolocation($request->input('contact.location'));

        $result->contact()->update(array_merge($request->input('contact') ,[
            'geolocation_title'  => $geolocation['geolocationTitle'],
            'geolocation_search' => $geolocation['geolocationSearch'],
        ]));

        $result->contact->socialNetwork()->sync($request->input('contact.social'));
    }

    /**
     *  destroy action for destroy relation
     */
    public function destroyDatatable($Company = null, $request = null, $result = null)
    {
        //
    }

    /**
     *  inline validate dialog form
     */
    public function validateDatatable()
    {
        return [
            'name'                        => 'required',
            'headline'                    => 'required',
            'company_employer_id'         => 'required',
            'short_description'           => 'required|min:150',
            'detail'                      => 'required|min:150',
            'founded_from'                => 'required',

            'contact.email'               => 'required|email',
            'contact.website'             => 'required|url',
            'contact.location'            => 'required',
            'contact.phone_number'        => 'required',
        ];
    }
}
