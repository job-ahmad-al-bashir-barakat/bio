<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use App\User;
use Modules\Control\Entities\Majer;

class UserFactory extends GlobalFactory
{

    /**
     *  get datatable query
     */
    public function getDatatable($User, $request)
    {
        $query = User::orderBy('is_admin')->get();

        return $this->table
            ->queryConfig('users')
            ->queryDatatable($query)
            ->queryAddColumn('is_active_label',function ($item) {
                return $item->is_active ? trans('control::app.yes') : trans('control::app.no') ;
            })
            ->queryAddColumn('is_admin_label',function ($item) {
                return $item->is_admin ? trans('control::app.yes') : trans('control::app.no') ;
            })
            ->queryAddColumn('is_active_icon',function ($item) {
                $is_active = $item->is_active  ? "fa fa-unlock" : "fa fa-unlock-alt";
                $text_color = $item->is_active ? "text-success" : "text-danger";
                return "<span data-key='{$item->id}' class='$text_color'><i class='{$is_active}'></i></span>";
            })
            ->queryAddColumn('is_admin_icon',function ($item) {
                $is_active = $item->is_admin  ? "fa fa-check" : "fa fa-close";
                $text_color = $item->is_admin ? "text-success" : "text-danger";
                return "<span data-key='{$item->id}' class='$text_color'><i class='$is_active'></i></span>";
            })
            ->queryUpdateButton()
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($User, $request)
    {
        return $this->table
            ->config('users',trans('control::app.users'))
            ->addViewField($this->name,'name', 'name')
            ->addViewField(trans('control::app.email'),'email','email')
            ->addSelect([1 => trans('control::app.yes') ,0 => trans('control::app.no') ],trans('control::app.active'),'is_active','is_active_label','is_active_label','required req','','',false)
            ->addSelect([1 => trans('control::app.yes') ,0 => trans('control::app.no') ],trans('control::app.admin'),'is_admin','is_admin_label','is_admin_label','required req','','',false)
            ->addActionButton(trans('control::app.admin') ,'is_admin_icon' ,'is_admin_icon')
            ->addActionButton(trans('control::app.active') ,'is_active_icon' ,'is_active_icon')
            ->addActionButton($this->update,'update' ,'update')
            ->render();
    }

    /**
     *  inline validate dialog form
     */
    public function validateDatatable()
    {
        return [];
    }
}
