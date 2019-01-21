<?php

namespace Modules\Control\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ControlController extends Controller
{
    public function index()
    {
        return \Redirect::intended(\RouteUrls::resumes());
    }

    function table($table) {

        $subPage = Str::slug($table ,'_');
        $subPage = \View::exists("control::tables.$subPage") ? "control::tables.$subPage" : false;

        return view('control::tables.table', [
            'table'   => $table,
            'param'   => '',
            'title'   => trans('control::app.'.str_replace('-','_',$table)),
            'subPage' => $subPage,
        ]);
    }
}
