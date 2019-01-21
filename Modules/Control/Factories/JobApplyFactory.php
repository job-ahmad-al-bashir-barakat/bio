<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Modules\Control\Entities\ApplyStatus;
use Modules\Control\Entities\JobApply;

class JobApplyFactory extends GlobalFactory
{

    /**
     *  get datatable query
     */
    public function getDatatable($ResumeApply, $request)
    {
        $query = JobApply::with(['resume','job.company','applyStatus'])->whereHas('job.company',function ($query) {
            $query->where('user_id','=',\Auth::id());
        })->get();

        $applyStatus = ApplyStatus::all()->pluck('name','id')->toArray();
        $ApplyStatusNew = ApplyStatus::where('code','=','new')->first();

        return $this->table
            ->queryConfig('job-apply')
            ->queryDatatable($query)
            ->queryAddColumn('resume',function ($item){
                return "<a href='".\RouteUrls::site_resume_detail($item->resume_id)."'>{$item->resume->name}</a>";
            })
            ->queryAddColumn('job',function ($item){
                return "<a href='".\RouteUrls::site_job_detail($item->job_id)."'>{$item->job->name}</a>";
            })
            ->queryAddColumn('sender_receiver',function ($item) {
                
                if($item->user_id == \Auth::id())
                    return "<span style='font-size: 20px;' class='text-success' ><i class='fa fa-long-arrow-" . reversePosition() ."'></i></span>";
                else
                    return "<span style='font-size: 20px;' class='text-danger'><i class='fa fa-long-arrow-" . position() . "'></i></span>";
            })
            ->queryAddColumn('info',function ($item) {

                if($item->applyStatus && $item->applyStatus['code'] == 'new')
                    return "<span><i class='fa fa-lock'></i></span>";
                else
                    return '<span data-key="'.$item->id.'" data-toggle="modal" data-target="#job-apply-modal" class="dialog-update datatable-icon-hand"><i class="icon icon-wrench"></i></span>';
            })
            ->queryAddColumn('apply_status_label',function ($item) use($applyStatus ,$ApplyStatusNew) {

                $name = $item->applyStatus ? $item->applyStatus['name'] : $ApplyStatusNew->name;
                $code = $item->applyStatus ? $item->applyStatus['code'] : $ApplyStatusNew->code;

                switch ($code)
                {
                    case 'new' : {  $color = 'primary'; }; break;
                    case 'connected' : {  $color = 'warning'; }; break;
                    case 'hired' : {  $color = 'success'; }; break;
                    default : {  $color = 'primary'; }; break;
                }

                if($item->user_id != \Auth::id())
                    $result = \Form::select('apply_status_id',$applyStatus,$item->apply_status_id,['data-key' => $item->id,'class' => 'apply-status']);
                else
                    $result = "<label class='label label-{$color}'>{$name}</label>";

                return $result;
            })
            ->queryAddColumn('interview_date_label',function ($item) {

                return $item->interview_date ? $item->interview_date : trans('control::app.no_set_yet');
            })
            ->queryAddColumn('interview_location_label',function ($item) {

                if(empty($item->interview_location))
                    return trans('control::app.no_set_yet');

                $location = geolocation($item->interview_location)['geolocationTitle'][\App::getLocale()];

                return "<span>
                        <input type='hidden' value='{$item->interview_location}'>
                        <a class='input-location-read hand'>$location</a>
                </span>";
            })
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($ResumeApply, $request)
    {
        $applyStatus = ApplyStatus::all()->pluck('name','id')->toArray();

        return $this->table
            ->config('job-apply',trans('control::app.job_apply'))
            ->addViewField(trans('control::app.job'),'job.name','resume.name','job')
            ->addViewField(trans('control::app.resume'),'resume.name','resume.name','resume')
            ->addViewField(trans('control::app.subject'),'subject','subject','','none')
            ->addViewField(trans('control::app.message'),'message','message','','none')
            ->addInputGroup(trans('control::app.interview_date'),'interview_date','interview_date','','fa fa-calendar','date','','',false)
            ->addViewField(trans('control::app.interview_date'),'interview_date','interview_date','interview_date_label')
            ->addInputGroup(trans('control::app.interview_location'),'interview_location' ,'interview_location','none','fa fa-map-marker','input-location hand',['data-modal' => '#modal-job-apply-input-location','readonly'],'',false)
            ->addViewField(trans('control::app.interview_location'),'interview_location','interview_location','interview_location_label')
            ->addViewField(trans('control::app.apply_status'),'apply_status_id','apply_status.name','apply_status_label')
            ->addViewField(trans('control::app.sender_receiver'),'sender_receiver','sender_receiver','sender_receiver','text-center all','','70px')
            ->addActionButton(trans('control::app.info'),'info','info','text-center all','','70px')
             ->addNavButton()
            ->render();
    }

    /**
     *  inline validate dialog form
     */
    public function validateDatatable()
    {
        return [
            'interview_date'     => 'required',
            'interview_location' => 'required',
        ];
    }
}
