<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Carbon\Carbon;
use Modules\Control\Entities\Job;

class JobFactory extends GlobalFactory
{

    /**
     *  get datatable query
     */
    public function getDatatable($Job, $request)
    {
        $query = Job::where('company_id','=',request()->get('company'))->get();

        return $this->table
            ->queryConfig('datatable-jobs')
            ->queryDatatable($query)
            ->queryAddColumn('is_filled_label',function ($item) {
                return $item->is_filled ? trans('control::app.yes') : trans('control::app.no') ;
            })
            ->queryAddColumn('job_status_label',function ($item) {

                switch ($item->job_status)
                {
                    case 'w' : {
                        $label = trans('control::app.waiting');
                        return "<lebel class='label label-success'>{$label}<label>";
                    }; break;

                    case 'c' : {
                        $label = trans('control::app.closed');
                        return "<lebel class='label label-danger'>{$label}<label>";
                    }; break;
                }

            })
            ->queryMultiAutocompleteTemplete('degree_temp','degree',lang('name'))
            ->queryUpdateButton('id')
            ->queryDeleteButton('id')
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($Job, $request)
    {
        $table = $this->table
            ->config('datatable-jobs',trans('control::app.jobs'),['gridSystem' => true ,'dialogWidth' => '60%'])
            ->addInputText($this->name,'name','name','req required')
            ->setPlaceholder(trans('control::app.salary_per_hour'))
            ->addInputNumber(trans('control::app.salary'),'salary','salary','req required','min=0')
            ->addInputNumber(trans('control::app.work_hour_num'),'work_hour_num','work_hour_num','req required','min=0 max=168') // 168 = 1 week
            ->addInputNumber(trans('control::app.experience_num'),'experience_num','experience_num','req required','min=0')
            ->setGridNormalCol(12)
            ->addTextArea(trans('control::app.short_description'),'short_description','short_description','req required none','rows=8')
            ->addTextArea(trans('control::app.detail'),'detail','detail','req required d:summernote-editor none','rows=8')
            ->setGridNormalCol(6)
            ->addHiddenInput('last_update','last_update',Carbon::now()->toDateString(),false,true)
            ->addHiddenInput('company_id', 'company_id',request()->get('company'),false,true)
            ->addAutocomplete('autocomplete/category',trans('control::app.category'),'category_id',lang('category.name'),lang('category.name'),'req required')
            ->addAutocomplete('autocomplete/contract',trans('control::app.contract'),'contract_id',lang('contract.name'),lang('contract.name'),'req required')
            ->startRelation('degree')
                ->addMultiAutocomplete('autocomplete/degree','degree_temp',trans('control::app.degree'),'degree.id',lang('degree.name'),lang('degree.name'),'req required none')
            ->endRelation()
            ->addSelect([1 => trans('control::app.yes') ,0 => ['title' => trans('control::app.no') , 'selected' => true] ],trans('control::app.filled'),'is_filled','is_filled_label','is_filled_label','required req')
            ->addSelect(['c' => trans('control::app.closed') ,'w' => ['title' => trans('control::app.waiting') ,'selected' => true] ],trans('control::app.job_status'),'job_status','job_status_label','job_status_label','required req')
            ->addActionButton($this->update,'update' ,'update')
            ->addActionButton($this->delete,'delete' ,'delete')
            ->addNavButton()
            ->render();

        return $table;
    }

    /**
     *  store action for save relation
     */
    public function storeDatatable($Job = null, $request = null, $result = null)
    {
        $result->degree()->sync(request()->input('degree.id'));
    }

    /**
     *  update action for update relation
     */
    public function updateDatatable($Job = null, $request = null, $result = null)
    {
        $result->degree()->sync(request()->input('degree.id'));
    }

    /**
     *  inline validate dialog form
     */
    public function validateDatatable()
    {
        return [
            'name'              => 'required',
            'salary'            => 'required|numeric|min:0',
            'work_hour_num'     => 'required|numeric|min:0',
            'experience_num'    => 'required|numeric|min:0',
            'short_description' => 'required|min:150',
            'detail'            => 'required|min:150',
            'category_id'       => 'required',
            'contract_id'       => 'required',
            'is_filled'         => 'required',
            'job_status'        => 'required',
            'degree.id'         => 'required',
        ];
    }
}
