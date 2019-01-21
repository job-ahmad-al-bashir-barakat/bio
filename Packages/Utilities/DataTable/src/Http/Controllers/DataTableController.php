<?php

namespace Aut\DataTable\Http\Controllers;

use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use Aut\DataTable\DataTableBuilder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Aut\DataTable\Http\Maker\BaseDataTableMaker;
use Aut\DataTable\Exceptions\NotFoundDataTableException;

use App\Http\Factory\DatatableMaker;
use Aut\DataTable\Http\Requests\DatatableRequest;

class DataTableController extends Controller
{
    protected $model;

    protected $middlewares;

    protected $middlewaresOption;

    protected $dataTableFunc;

    protected $stopOperation;

    protected $factory;

    protected $table;

    public function __construct()
    {
        $this->initModel();

        if(!empty($this->middlewares)) {

            $option = empty($this->middlewaresOption) ? [] : $this->middlewaresOption;

            $this->middleware($this->middlewares,$option);
        }
    }

    public function generator()
    {
        $passwordGenerator = substr(uniqid(str_random(8)),0,8);
        return  $passwordGenerator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BaseDatatableMaker $maker)
    {
        return $maker->callTable($this->factory ,$this->factoryFunction('get_'.$this->dataTableFunc) ,$this->model ,request());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(BaseDataTableMaker $maker)
    {
        $dataTable = $maker->callTable($this->factory ,$this->factoryFunction('build_'.$this->dataTableFunc) ,$this->model ,request());

        return  view('datatable::table' ,compact('dataTable'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DatatableRequest $request, BaseDatatableMaker $maker)
    {
        if(method_exists($this->factory,$this->factoryFunction('validate_'.$this->dataTableFunc)))
            $this->validate($request ,$maker->validate($this->factory ,$this->factoryFunction('validate_'.$this->dataTableFunc)));

        $result = [];

        if(in_array('store',$this->stopOperation ,true) == false)
        {
            $model = $this->model;

            $req = $request->input();

            $result = $model::create($req);
        }

        if(method_exists($this->factory,$this->factoryFunction('store_'.$this->dataTableFunc)))
            $maker->callOperation($this->factory ,$this->factoryFunction('store_'.$this->dataTableFunc) ,$this->model ,request() ,$result);

        return Response::json(['operation_message' => trans('datatable::table.oper.success')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DatatableRequest $request, $model, $id , BaseDatatableMaker $maker)
    {
        if(method_exists($this->factory,$this->factoryFunction('validate_'.$this->dataTableFunc)))
            $this->validate($request ,$maker->validate($this->factory ,$this->factoryFunction('validate_'.$this->dataTableFunc)));

        $result = [];

        if(in_array('update',$this->stopOperation) == false)
        {
            $model = $this->model;

            $req = $request->input();

            $result = $model::findOrFail($id);

            $result->update($req);
        }

        if(method_exists($this->factory,$this->factoryFunction('update_'.$this->dataTableFunc)))
            $maker->callOperation($this->factory ,$this->factoryFunction('update_'.$this->dataTableFunc) ,$this->model ,request() ,$result);

        return Response::json(['operation_message' => trans('datatable::table.oper.success')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($model ,$id , BaseDatatableMaker $maker)
    {
        $result = [];

        if(in_array('destroy',$this->stopOperation) == false)
        {
            $model = $this->model;

            $result = $model::findOrFail($id);

            $model::destroy([$id]);
        }

        if(method_exists($this->factory,$this->factoryFunction('destroy_'.$this->dataTableFunc)))
            $maker->callOperation($this->factory ,$this->factoryFunction('destroy_'.$this->dataTableFunc) ,$this->model ,['request' => request() ,'id' => $id] ,$result);

        return Response::json(['operation_message' => trans('datatable::table.oper.success')]);
    }

    private function factoryFunction($mthod)
    {
        $ref = new \ReflectionClass($this->factory);

        if($ref->getShortName() != 'DatatableMaker') {

            switch (config('datatable.functionCase.factory'))
            {
                case 'camelCase': return camel_case($mthod); break;
                case 'snakeCase': return snake_case($mthod); break;
            }
        }
        else
        {
            switch (config('datatable.functionCase.maker'))
            {
                case 'camelCase': return camel_case($mthod); break;
                case 'snakeCase': return snake_case($mthod); break;
            }
        }
    }

    private function defaultFactory()
    {
        $table   = $this->table;
        $ucfirst = ucfirst($this->table);
        $defaultFactory = preg_replace("/Entities/","Factories",$this->model);
        $defaultFactory = preg_replace("/$table/",$ucfirst,$defaultFactory);
        $defaultFactory = "{$defaultFactory}Factory";
        return $defaultFactory;
    }

    private function factoryInstance()
    {
        $default = class_exists($this->defaultFactory());

        if(class_exists($this->factory) || $default)
        {
            $factory = $this->factory != '' ? $this->factory :  $this->defaultFactory();

            $factory = new $factory(new DataTableBuilder());

            $this->factory = $factory;
        }
        else
        {
            $factory = new DatatableMaker(new DataTableBuilder());

            $this->factory = $factory;
        }
    }

    private function initModel()
    {
        if(Route::getCurrentRoute() !== null)
        {
            $table = Route::getCurrentRoute()->parameter('model');

            $tableSet = config('datatableModels.' . $table);

            if (!$tableSet) {
                throw new NotFoundDataTableException();
            }

            $this->table              = $table;
            $this->factory            = isset($tableSet['factory']) ? $tableSet['factory'] : '';
            $this->model              = isset($tableSet['model']) ? $tableSet['model'] : '';
            $this->middlewares        = isset($tableSet['middlewares']) ? $tableSet['middlewares'] : '';
            $this->middlewaresOption  = isset($tableSet['middlewaresOption']) ? $tableSet['middlewaresOption'] : '';
            $this->dataTableFunc      = isset($tableSet['dataTableFunc']) ? $tableSet['dataTableFunc'] : 'datatable';
            $this->stopOperation      = isset($tableSet['stopOperation']) ? $tableSet['stopOperation'] : [];
            $this->factoryInstance();
        }
    }
}
