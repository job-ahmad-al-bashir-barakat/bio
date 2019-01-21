<?php

namespace Aut\DataTable;

use App;
use Aut\DataTable\Traits\Dialog;
use Aut\DataTable\Traits\JavaScript;
use Aut\DataTable\Traits\QueryDataTable;
use Aut\DataTable\Traits\Table;
use Illuminate\Support\Str;
use Mockery\CountValidator\Exception;

/**
 * yajra
 *
 * laravel-datatables
 * laravel-datatables-html
 * laravel-datatables-buttons
 *
 * Class DataTableBuilder
 * @package Aut\DataTable
 */
class DataTableBuilder
{
    use Dialog , Table, QueryDataTable ,JavaScript;

    protected $id;

    protected $url;

    protected $model;

    protected $dataTable;

    protected $columns;

    protected $locale;

    protected $optionDatatableConfig;

    protected $tableButtons = ['choosen' /*,'export'*/ ,'code' ,'destroy' ,'reload','add']; //,'copy' ,'pdf' , 'print' ,'csv' ,'excel'

    protected $globalScript = '';

    protected $index = 0;

    protected $groupCount = 0;

    protected $rowGroup;

    protected $dir;

    protected $tabs = [];

    protected $tab = [];

    protected $relation_key;

    protected $partOfContent = "";

    protected $gridSystem = [];

    protected $gridSystemResult = [];

    protected $rowDetail = '';

    protected $customResponsiveTemplete = '';

    protected $componentOptions = [];

    protected $customHtml = '';

    protected $isCustom = false;

    protected $HTab = [];

    protected $HTabs = [];

    protected $options = [
    ];

    protected $params = [
        'name'        => '',
        'class'       => '',
        'value'       => '',
        'attr'        => '',
        'placeholder' => '',
        'lang'        => '',
    ];

    protected $events = [
        'onAdd'          => '',
        'onUpdate'       => '',
        'onDelete'       => '',
        'onLoad'         => '',
        'onTableCreate'  => '',
        'modalOpen'      => '',
        'modalClose'     => '',
        'modalAdd'       => '',
        'modalUpdate'    => '',
        'rowDetailClick' => '',
        'onTabClick'     => '',
    ];

    protected $langs = [];

    protected $langSupportedLocales = null;

    protected $blade = [];

    public function __construct()
    {
        $this->dataTable = collect();

        $this->columns = [];

        $this->locale = App::getLocale();

        $this->dir = \LaravelLocalization::getCurrentLocaleDirection();

        $this->langs  = \LaravelLocalization::getSupportedLanguagesKeys();

        $this->langSupportedLocales  = \LaravelLocalization::getSupportedLocales();
    }

    protected function defaultProp()
    {
        $length = array_merge($this->optionDatatableConfig['rowCount'] ,[10,25,50,100, -1]);
        $lengthWithAll = array_merge($this->optionDatatableConfig['rowCount'] , [10,25,50,100,'All']);

        if($this->optionDatatableConfig['responsive'])
            $this->dataTable->put('responsive', ['details' => ['renderer' => 'responsive_renderer']]);
        $this->dataTable->put('autoWidth', true);
        $this->dataTable->put('processing', true);
        $this->dataTable->put('stateSave' , false);
        $this->dataTable->put('serverSide', true);
        $this->dataTable->put('deferRender', true);
        $this->dataTable->put('paging' , true);
        $this->dataTable->put('pagingType' , $this->optionDatatableConfig['pagingType']);
        $this->dataTable->put('lengthMenu', [$length ,$lengthWithAll]);
        $this->dataTable->put('language', $this->setLanguage());
        $this->dataTable->put('columnDefs', $this->exceptColumn());
        $this->dataTable->put('buttons', []);
        $this->dataTable->put('dom', $this->setButtonPosition());
        $this->dataTable->put('searchDelay', 900);
        $this->dataTable->put('fixedColumns', [
            'leftColumns'  => $this->optionDatatableConfig['fixedStart'],
            'rightColumns' => $this->optionDatatableConfig['fixedEnd']
        ]);
        if($this->optionDatatableConfig['scrollX'])
            $this->dataTable->put('scrollX', true);
        if($this->optionDatatableConfig['scrollY']) {
            $this->dataTable->put('scrollY', $this->optionDatatableConfig['scrollY']);
            $this->dataTable->put('scrollCollapse', true);
        }
    }

    /**
     * @param $option
     * @return array
     *
     * pagingType: numbers|simple|simple_numbers|full|full_numbers|first_last_numbers
     */
    private function setDefaultConfig($option)
    {
        $optionDefault = [
            'formClass'         => '',
            'formAttr'          => '',
            'dialogWidth'       => '',
            'disableDialog'     => false,
            'removeElement'     => false,
            'removeSomeElement' => [],
            'responsive'        => true,
            'scrollX'           => false,
            'scrollY'           => '300px',
            'filter'            => false,
            'sortable'          => false,
            'fixedStart'        => 0,
            'fixedEnd'          => 0,
            'rowCount'          => [],
            'withTab'           => false,
            'gridSystem'        => false,
            'usedComponent'     => false,
            'pagingType'        => 'simple_numbers',
        ];

        $optionDefault = array_merge($optionDefault ,$option);

        return $optionDefault;
    }

    /**
     * @param string $tableId
     * @param string $caption
     * @param array $option
     * @return $this
     */
    function config($tableId = 'datatable', $caption = '', $option = [
        'formClass'         => '',
        'formAttr'          => '',
        'dialogWidth'       => '',
        'disableDialog'     => false,
        'removeElement'     => false,
        'removeSomeElement' => [],
        'scrollX'           => false,
        'scrollY'           => '300px',
        'filter'            => false,
        'sortable'          => false,
        'fixedStart'        => 0,
        'fixedEnd'          => 0,
        'rowCount'          => [],
        'withTab'           => false,
        'gridSystem'        => false,
        'usedComponent'     => false,
        'pagingType'        => 'simple_numbers',
    ])
    {
        $dataTable = $this->dataTable;

        $this->id = $tableId;

        if(count(request()->input()) > 0)
        {
            $param = '?';

            foreach (request()->input() as $index => $item)
            {
                $param .= "$index=$item&";
            }
        }
        else
        {
            $param = '';
        }

        $model = request()->route('model');

        $this->model = $model;

        $this->url = "datatable/$model/table";

        $this->dialogCaption = $caption;

        $this->optionDatatableConfig = $this->setDefaultConfig($option);

        $this->defaultProp();

        $dataTable->put('ajax', [
            'url'  =>  datatableLocalizeURL("datatable/$model/get/table{$param}"),
            'type' => 'POST',
        ]);

        $this->addIndex();

        /*
         * Grid System
         */
        if($this->optionDatatableConfig['gridSystem'])
        {
            $this->gridSystem =  config('datatable.gridSystem');
        }

        $this->gridSystemResult = gridSystemResult($this->optionDatatableConfig['gridSystem'] ,$this->gridSystem);

        /**
         * Custom Responsive Templete
         */
        if($this->optionDatatableConfig['responsive']) {

            if(config('datatable.customResponsiveTemplete'))
                $removeSpaces = autConvertString(view(config('datatable.customResponsiveTempleteView'))->render());
            else
                $removeSpaces = autConvertString(view('datatable::_responsive')->render());

            $this->customResponsiveTemplete = $removeSpaces;
        }

        return $this;
    }

    /**
     * @param bool $formHorizontal
     * @return $this
     * @throws \Exception
     */
    function gridSystemConfig($formHorizontal = false)
    {
        if(!$this->optionDatatableConfig['gridSystem'])
            throw new \Exception('Opsss o_o !!! -_- sorry this function is only enabled when you activate gridSystem property.');

        $this->gridSystem['formHorizontal'] = $formHorizontal;

        return $this;
    }

    /**
     * @param int $cols
     * @param string $type
     * @return $this
     * @throws \Exception
     */
    function setGridNormalCol($cols = 6 , $type = 'lg|md|sm|xs')
    {
        if($this->gridSystem['formHorizontal'])
            throw new \Exception('Opsss o_o !!! -_- sorry this function is only for Normal Form.');

        $this->gridSystem['global'] = [
            'cols' => $cols,
            'type' => $type
        ];

        $this->gridSystemResult = gridSystemResult($this->optionDatatableConfig['gridSystem'] ,$this->gridSystem);

        return $this;
    }

    /**
     * @param int $cols
     * @param string $type
     * @return $this
     * @throws \Exception
     */
    function setGridHorizontalTitle($cols = 3 , $type = 'lg|md|sm|xs')
    {
        if(!$this->gridSystem['formHorizontal'])
            throw new \Exception('Opsss o_o !!! -_- sorry this function is only for Horizontal Form.');

        $this->gridSystem['label'] = [
            'cols' => $cols,
            'type' => $type
        ];

        $this->gridSystemResult = gridSystemResult($this->optionDatatableConfig['gridSystem'] ,$this->gridSystem);

        return $this;
    }

    /**
     * @param int $cols
     * @param string $type
     * @return $this
     * @throws \Exception
     */
    function setGridHorizontalCol($cols = 9 , $type = 'lg|md|sm|xs')
    {
        if(!$this->gridSystem['formHorizontal'])
            throw new \Exception('Opsss o_o !!! -_- sorry this function is only for Horizontal Form.');

        $this->gridSystem['input'] = [
            'cols' => $cols,
            'type' => $type
        ];

        $this->gridSystemResult = gridSystemResult($this->optionDatatableConfig['gridSystem'] ,$this->gridSystem);

        return $this;
    }

    /**
     * @param string $id
     * @param string $html
     * @param string $class
     * @param string $attr
     * @return $this
     */
    function addCont($id = '' , $html ='' , $class ='' , $attr ='')
    {
        $isCustom = $this->_addCont($id ,$html ,$class ,$attr ,$this->isCustom);

        if($this->isCustom)
            $this->customHtml .= $isCustom;

        return $this;
    }

    /**
     * @param string $id
     * @param string $class
     * @param string $attr
     * @return $this
     */
    function startCont($id = '' , $class = '' , $attr = '')
    {
        $isCustom = $this->_startCont($id ,$class ,$attr ,$this->isCustom);

        if($this->isCustom)
            $this->customHtml .= $isCustom;

        return $this;
    }

    /**
     * @return $this
     */
    function endCont()
    {
        $isCustom = $this->_endCont($this->isCustom);

        if($this->isCustom)
            $this->customHtml .= $isCustom;

        return $this;
    }

    /**
     * @param string $id
     * @param string $title
     * @param string $class
     * @param string $attr
     * @return $this
     */
    function startFieldSet($id = '' , $title = '', $class = '' , $attr = '')
    {
        $isCustom = $this->_startFieldSet($id ,$title ,$class ,$attr ,$this->isCustom);

        if($this->isCustom)
            $this->customHtml .= $isCustom;

        return $this;
    }

    /**
     * @return $this
     */
    function endFieldSet()
    {
        $isCustom = $this->_endFieldSet($this->isCustom);

        if($this->isCustom)
            $this->customHtml .= $isCustom;

        return $this;
    }

    /**
     * @param $relation
     * @return $this
     */
    function startRelation($relation)
    {
        $this->relation_key = $relation;

        return $this;
    }

    /**
     * @return $this
     */
    function endRelation()
    {
        $this->relation_key = '';

        return $this;
    }

    /**
     * @param $title
     * @param string $icon
     * @return $this
     * @throws \Exception
     */
    function startTab($title , $icon ='' , $class = '', $attr = '')
    {
        if(!$this->optionDatatableConfig['withTab'])
            throw new \Exception('Oppps !!! you must enable withTab property');

        $this->tab = ['title' => $title ,'icon' => $icon , 'class' => $class, 'attr' => $attr];

        return $this;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    function endTab()
    {
        if(!isset($this->tab['content']))
            throw new \Exception('oh -_- oh !! what are you doing dont pass tab without any content >_<');

        $this->tabs[] = $this->tab;

        $this->partOfContent = '';

        return $this;
    }

    /**
     * @param string $id
     * @param string $class
     * @param string $attr
     * @return $this
     */
    function openFromGroup($id = '', $class = '' , $attr = '')
    {
        $this->startCont($id ,trim("clearfix $class"),$attr);

        return $this;
    }

    /**
     * @return $this
     */
    function closeFromGroup()
    {
        $this->endCont();

        return $this;
    }

    /**
     * @return $this
     */
    function startHorizontalTab()
    {
        $this->HTabs = [];

        return $this;
    }

    /**
     * @param $id
     * @param $title
     * @param string $class
     * @param bool $active
     * @return $this
     */
    function openHorizontalTab($id , $title , $class = '' , $active = false)
    {
        $this->isCustom = true;

        $star = matchClass('req' ,$class);

        $this->HTab = ['id' => $id ,'title' => $title ,'class' => $class ,'star' => $star ,'active' => $active];

        return $this;
    }

    /**
     * @return $this
     */
    function closeHorizontalTab()
    {
        $this->HTabs[] = array_merge(['content' => $this->customHtml] ,$this->HTab);

        $this->customHtml = '';

        $this->isCustom = false;

        return $this;
    }

    /**
     * @return $this
     */
    function endHorizontalTab()
    {
        $this->_addComponent(view('datatable::_htab' ,['htabs' => $this->HTabs ])->render());

        $this->HTabs = [];

        return $this;
    }

    /**
     * @param string $data
     * @param string $name
     * @param string $value
     * @param bool $permanent
     * @return $this
     */
    function addPrimaryKey($data = '', $name = '' , $value = '', $permanent=false)
    {
        $instance = config('datatableModels.'.$this->model)['model'];

        $pointer = new $instance;

        $this->addField([
            "type"       => 'hidden',
            "data"       => $data != '' ? $data : $pointer->getKeyName(),
            "name"       => $name != '' ? $name : $pointer->getKeyName(),
            "value"      => $value,
            "attr"       => 'data-key=true'.' '.($permanent == true ? 'data-permanent=true' : ''),
            "class"      => 'd:primary-key',
            "visible"    => false,
            "orderable"  => false,
            "searchable" => false,
            "choosen"    => false,
            "printable"  => false
        ]);

        return $this;
    }

    /**
     * @param string $data
     * @param string $name
     * @param string $value
     * @param bool $primaryKey
     * @param bool $permanent
     * @return $this
     */
    function addHiddenInput($data = '', $name = '', $value = '', $primaryKey = false, $permanent=false)
    {
        $this->addField([
            "type"       => 'hidden',
            "data"       => $data,
            "name"       => $name,
            "value"      => $value,
            "attr"       => ($primaryKey == true ? 'data-key="true"' : '').' '.($permanent == true ? 'data-permanent=true' : ''),
            "class"      => $primaryKey  == true ? 'd:primary-key' : '',
            "visible"    => false,
            "orderable"  => false,
            "searchable" => false,
            "choosen"    => false,
            "printable"  => false
        ]);

        return $this;
    }

    /**
     * @return $this
     */
    function addIndex()
    {
        $this->addField([
            "title"      => '#',
            "type"       => 'index',
            "data"       => 'DT_Row_Index',
            "name"       => 'DT_Row_Index',
            "width"      => '20px',
            "class"      => 'index center all',
            "visible"    => true,
            "orderable"  => false,
            "searchable" => false,
            "choosen"    => false,
            "printable"  => true,
        ]);

        //force datatable to order
        //$this->dataTable->put('order', [[ 1, "asc" ]]);

        return $this;
    }

    /**
     * @param string $title
     * @param string $data
     * @param string $name
     * @param string $colClass
     * @param string $dialogAttr
     * @param string $colWidth
     * @param bool $visible
     * @param bool $orderable
     * @param bool $searchable
     * @param bool $choosen
     * @param bool $printable
     * @return $this
     */
    function addInputText
    (
        $title      = '',
        $data       = '',
        $name       = '',
        $colClass   = '',
        $dialogAttr = '',
        $colWidth   = '',
        $visible    = true,
        $orderable  = true,
        $searchable = true,
        $choosen    = true,
        $printable  = true
    )
    {
        $this->addField([
            "type"       => 'text',
            "title"      => $title,
            "data"       => $data,
            "name"       => $name,
            "class"      => $colClass,
            "width"      => $colWidth,
            "attr"       => $dialogAttr,
            "visible"    => $visible,
            "orderable"  => $orderable,
            "searchable" => $searchable,
            "choosen"    => $choosen,
            "printable"  => $printable,
        ]);

        return $this;
    }

    /**
     * @param string $title
     * @param string $data
     * @param string $name
     * @param string $colClass
     * @param string $dialogAttr
     * @param string $colWidth
     * @param bool $visible
     * @param bool $orderable
     * @param bool $searchable
     * @param bool $choosen
     * @param bool $printable
     * @return $this
     */
    function addInputDate
    (
        $title      = '',
        $data       = '',
        $name       = '',
        $colClass   = '',
        $dialogAttr = '',
        $colWidth   = '',
        $visible    = true,
        $orderable  = true,
        $searchable = true,
        $choosen    = true,
        $printable  = true
    )
    {
        $this->addField([
            "type"       => 'date',
            "title"      => $title,
            "data"       => $data,
            "name"       => $name,
            "class"      => $colClass,
            "width"      => $colWidth,
            "attr"       => $dialogAttr,
            "visible"    => $visible,
            "orderable"  => $orderable,
            "searchable" => $searchable,
            "choosen"    => $choosen,
            "printable"  => $printable,
        ]);

        return $this;
    }

    /**
     * @param string $title
     * @param string $data
     * @param string $name
     * @param string $colClass
     * @param string $dialogAttr
     * @param string $colWidth
     * @param bool $visible
     * @param bool $orderable
     * @param bool $searchable
     * @param bool $choosen
     * @param bool $printable
     * @return $this
     */
    function addInputTime
    (
        $title      = '',
        $data       = '',
        $name       = '',
        $colClass   = '',
        $dialogAttr = '',
        $colWidth   = '',
        $visible    = true,
        $orderable  = true,
        $searchable = true,
        $choosen    = true,
        $printable  = true
    )
    {
        $this->addField([
            "type"       => 'time',
            "title"      => $title,
            "data"       => $data,
            "name"       => $name,
            "class"      => $colClass,
            "width"      => $colWidth,
            "attr"       => $dialogAttr,
            "visible"    => $visible,
            "orderable"  => $orderable,
            "searchable" => $searchable,
            "choosen"    => $choosen,
            "printable"  => $printable,
        ]);

        return $this;
    }

    /**
     * @param string $title
     * @param string $data
     * @param string $name
     * @param string $colClass
     * @param string $dialogAttr
     * @param string $colWidth
     * @param bool $visible
     * @param bool $orderable
     * @param bool $searchable
     * @param bool $choosen
     * @param bool $printable
     * @return $this
     */
    function addInputDateTimeLocal
    (
        $title      = '',
        $data       = '',
        $name       = '',
        $colClass   = '',
        $dialogAttr = '',
        $colWidth   = '',
        $visible    = true,
        $orderable  = true,
        $searchable = true,
        $choosen    = true,
        $printable  = true
    )
    {
        $this->addField([
            "type"       => 'datetime-local',
            "title"      => $title,
            "data"       => $data,
            "name"       => $name,
            "class"      => $colClass,
            "width"      => $colWidth,
            "attr"       => $dialogAttr,
            "visible"    => $visible,
            "orderable"  => $orderable,
            "searchable" => $searchable,
            "choosen"    => $choosen,
            "printable"  => $printable,
        ]);

        return $this;
    }

    /**
     * @param string $title
     * @param string $data
     * @param string $name
     * @param string $colClass
     * @param string $dialogAttr
     * @param string $colWidth
     * @param bool $visible
     * @param bool $orderable
     * @param bool $searchable
     * @param bool $choosen
     * @param bool $printable
     * @return $this
     */
    function addInputDateTime
    (
        $title      = '',
        $data       = '',
        $name       = '',
        $colClass   = '',
        $dialogAttr = '',
        $colWidth   = '',
        $visible    = true,
        $orderable  = true,
        $searchable = true,
        $choosen    = true,
        $printable  = true
    )
    {
        $this->addField([
            "type"       => 'datetime',
            "title"      => $title,
            "data"       => $data,
            "name"       => $name,
            "class"      => $colClass,
            "width"      => $colWidth,
            "attr"       => $dialogAttr,
            "visible"    => $visible,
            "orderable"  => $orderable,
            "searchable" => $searchable,
            "choosen"    => $choosen,
            "printable"  => $printable,
        ]);

        return $this;
    }

    /**
     * @param string $title
     * @param string $data
     * @param string $name
     * @param string $colClass
     * @param string $dialogAttr
     * @param string $colWidth
     * @param bool $visible
     * @param bool $orderable
     * @param bool $searchable
     * @param bool $choosen
     * @param bool $printable
     * @return $this
     */
    function addInputMonth
    (
        $title      = '',
        $data       = '',
        $name       = '',
        $colClass   = '',
        $dialogAttr = '',
        $colWidth   = '',
        $visible    = true,
        $orderable  = true,
        $searchable = true,
        $choosen    = true,
        $printable  = true
    )
    {
        $this->addField([
            "type"       => 'month',
            "title"      => $title,
            "data"       => $data,
            "name"       => $name,
            "class"      => $colClass,
            "width"      => $colWidth,
            "attr"       => $dialogAttr,
            "visible"    => $visible,
            "orderable"  => $orderable,
            "searchable" => $searchable,
            "choosen"    => $choosen,
            "printable"  => $printable,
        ]);

        return $this;
    }

    /**
     * @param string $title
     * @param string $data
     * @param string $name
     * @param string $colClass
     * @param string $dialogAttr
     * @param string $colWidth
     * @param bool $visible
     * @param bool $orderable
     * @param bool $searchable
     * @param bool $choosen
     * @param bool $printable
     * @return $this
     */
    function addInputWeek
    (
        $title      = '',
        $data       = '',
        $name       = '',
        $colClass   = '',
        $dialogAttr = '',
        $colWidth   = '',
        $visible    = true,
        $orderable  = true,
        $searchable = true,
        $choosen    = true,
        $printable  = true
    )
    {
        $this->addField([
            "type"       => 'week',
            "title"      => $title,
            "data"       => $data,
            "name"       => $name,
            "class"      => $colClass,
            "width"      => $colWidth,
            "attr"       => $dialogAttr,
            "visible"    => $visible,
            "orderable"  => $orderable,
            "searchable" => $searchable,
            "choosen"    => $choosen,
            "printable"  => $printable,
        ]);

        return $this;
    }

    /**
     * @param string $title
     * @param string $data
     * @param string $name
     * @param string $colClass
     * @param string $dialogAttr
     * @param string $colWidth
     * @param bool $visible
     * @param bool $orderable
     * @param bool $searchable
     * @param bool $choosen
     * @param bool $printable
     * @return $this
     */
    function addInputEmail
    (
        $title      = '',
        $data       = '',
        $name       = '',
        $colClass   = '',
        $dialogAttr = '',
        $colWidth   = '',
        $visible    = true,
        $orderable  = true,
        $searchable = true,
        $choosen    = true,
        $printable  = true
    )
    {
        $this->addField([
            "type"       => 'email',
            "title"      => $title,
            "data"       => $data,
            "name"       => $name,
            "class"      => $colClass,
            "width"      => $colWidth,
            "attr"       => $dialogAttr,
            "visible"    => $visible,
            "orderable"  => $orderable,
            "searchable" => $searchable,
            "choosen"    => $choosen,
            "printable"  => $printable,
        ]);

        return $this;
    }

    /**
     * @param string $title
     * @param string $data
     * @param string $name
     * @param string $colClass
     * @param string $dialogAttr
     * @param string $colWidth
     * @param bool $visible
     * @param bool $orderable
     * @param bool $searchable
     * @param bool $choosen
     * @param bool $printable
     * @return $this
     */
    function addInputUrl
    (
        $title      = '',
        $data       = '',
        $name       = '',
        $colClass   = '',
        $dialogAttr = '',
        $colWidth   = '',
        $visible    = true,
        $orderable  = true,
        $searchable = true,
        $choosen    = true,
        $printable  = true
    )
    {
        $this->addField([
            "type"       => 'url',
            "title"      => $title,
            "data"       => $data,
            "name"       => $name,
            "class"      => $colClass,
            "width"      => $colWidth,
            "attr"       => $dialogAttr,
            "visible"    => $visible,
            "orderable"  => $orderable,
            "searchable" => $searchable,
            "choosen"    => $choosen,
            "printable"  => $printable,
        ]);

        return $this;
    }

    /**
     * @param string $title
     * @param string $id
     * @param string $name
     * @param string $value
     * @param string $class
     * @param string $attr
     * @return $this
     */
    function addInputTextDialog
    (
        $title = '',
        $id    = '',
        $name  = '',
        $value = '',
        $class = '',
        $attr  = ''
    )
    {
        $this->_Input($title ,$id ,$name , $value,'text' ,$class ,$attr);

        return $this;
    }

    /**
     * @param array $cols
     * @param string $colClass
     * @param string $colWidth
     * @param string $dialogAttr
     * @param bool $visible
     * @param bool $orderable
     * @param bool $searchable
     * @param bool $choosen
     * @param bool $printable
     * @return $this
     */
    function addMultiInputTextLangs
    (
        $cols       = [],
        $colClass   = '',
        $colWidth   = '',
        $dialogAttr = '',
        $visible    = true,
        $orderable  = true,
        $searchable = true,
        $choosen    = true,
        $printable  = true
    )
    {
        $this->addMultiInputLangs
        (
            $cols       ,
            'text'      ,
            $colClass   ,
            $colWidth   ,
            $dialogAttr ,
            $visible    ,
            $orderable  ,
            $searchable ,
            $choosen    ,
            $printable
        );

        return $this;
    }

    /**
     * @param array $cols
     * @param string $colClass
     * @param string $colWidth
     * @param string $dialogAttr
     * @param bool $visible
     * @param bool $orderable
     * @param bool $searchable
     * @param bool $choosen
     * @param bool $printable
     * @return $this
     */
    function addMultiTextareaLangs
    (
        $cols       = [],
        $colClass   = '',
        $colWidth   = '',
        $dialogAttr = '',
        $visible    = true,
        $orderable  = true,
        $searchable = true,
        $choosen    = true,
        $printable  = true
    )
    {
        $this->addMultiInputLangs
        (
            $cols       ,
            'textarea',
            $colClass   ,
            $colWidth   ,
            $dialogAttr ,
            $visible    ,
            $orderable  ,
            $searchable ,
            $choosen    ,
            $printable
        );

        return $this;
    }

    /**
     * @param array $cols
     * @param string $type
     * @param string $colClass
     * @param string $colWidth
     * @param string $dialogAttr
     * @param bool $visible
     * @param bool $orderable
     * @param bool $searchable
     * @param bool $choosen
     * @param bool $printable
     * @return $this
     */
    protected function addMultiInputLangs
    (
        $cols       = [],
        $type       = 'text',
        $colClass   = '',
        $colWidth   = '',
        $dialogAttr = '',
        $visible    = true,
        $orderable  = true,
        $searchable = true,
        $choosen    = true,
        $printable  = true
    )
    {
        foreach ($cols as $index => $col)
        {
            $relation_key = $this->relation_key;

            $relation = $relation_key
                ? $relation_key.".trans_$col"
                : "trans_$col";

            $this->startRelation($relation);

            // use this tabs when you need to add textarea ckeditor
            $hasTab = matchClass('d:tabs' ,$colClass);

            if($hasTab)
                $this->startHorizontalTab();

            foreach ($this->langSupportedLocales as $index => $lang)
            {
                $title = trans("datatable::table.$col");

                $title = preg_match('/datatable::/',$title) ? "app.$col" : "datatable::table.$col";

                $title = trans($title)." ({$lang['native']})";

                if($hasTab)
                    $this->openHorizontalTab("{$col}_{$index}" ,$title ,'req' ,$index == App::getLocale() ? true : false);

                $this->addField([
                    "type"       => $type,
                    "title"      => $title,
                    "data"       => "{$col}_{$index}" ,
                    "name"       => config('datatable.isLangs')
                        ? $relation_key ? $relation_key.".lang_$col.$index.text" : "lang_$col.$index.text"
                        : $relation_key ? $relation_key.".{$col}_{$index}" : "{$col}_{$index}",
                    "class"      => "$index $colClass",
                    "width"      => $colWidth,
                    "attr"       => $dialogAttr,
                    "visible"    => $visible,
                    "orderable"  => $orderable,
                    "searchable" => $searchable,
                    "choosen"    => $choosen,
                    "printable"  => $printable,
                ]);

                if($hasTab)
                    $this->closeHorizontalTab();
            }

            if($hasTab)
                $this->endHorizontalTab();

            $this->endRelation();
        }
    }

    /**
     * @param string $title
     * @param string $data
     * @param string $name
     * @param string $colClass
     * @param string $dialogAttr
     * @param string $colWidth
     * @param bool $visible
     * @param bool $orderable
     * @param bool $searchable
     * @param bool $choosen
     * @param bool $printable
     * @return $this
     */
    function addInputPassword
    (
        $title      = '',
        $data       = '',
        $name       = '',
        $colClass   = '',
        $dialogAttr = '',
        $colWidth   = '',
        $visible    = true,
        $orderable  = true,
        $searchable = true,
        $choosen    = true,
        $printable  = false
    )
    {
        $this->addField([
            "type"       => 'password',
            "title"      => $title,
            "data"       => $data,
            "name"       => $name,
            "class"      => $colClass,
            "width"      => $colWidth,
            "attr"       => $dialogAttr,
            "visible"    => $visible,
            "orderable"  => $orderable,
            "searchable" => $searchable,
            "choosen"    => $choosen,
            "printable"  => $printable
        ]);

        return $this;
    }

    /**
     * @param string $title
     * @param string $data
     * @param string $name
     * @param string $colClass
     * @param string $groupIcon
     * @param string $groupClass
     * @param string $dialogAttr
     * @param string $colWidth
     * @param bool $visible
     * @param bool $orderable
     * @param bool $searchable
     * @param bool $choosen
     * @param bool $printable
     * @return $this
     */
    function addInputGroup
    (
        $title      = '',
        $data       = '',
        $name       = '',
        $colClass   = '',
        $groupIcon  = '',
        $groupClass ='',
        $dialogAttr = '',
        $colWidth   = '',
        $visible    = true,
        $orderable  = true,
        $searchable = true,
        $choosen    = true,
        $printable  = true
    )
    {
        $this->addField([
            "type"       => 'group',
            "title"      => $title,
            "data"       => $data,
            "name"       => $name,
            "class"      => $colClass,
            "groupIcon"  => $groupIcon,
            "groupClass" => $groupClass,
            "attr"       => $dialogAttr,
            "width"      => $colWidth,
            "visible"    => $visible,
            "orderable"  => $orderable,
            "searchable" => $searchable,
            "choosen"    => $choosen,
            "printable"  => $printable,
        ]);

        return $this;
    }

    /**
     * @param string $title
     * @param string $data
     * @param string $name
     * @param string $colClass
     * @param string $dialogAttr
     * @param string $colWidth
     * @param bool $visible
     * @param bool $orderable
     * @param bool $searchable
     * @param bool $choosen
     * @param bool $printable
     * @return $this
     */
    function addTextArea
    (
        $title      = '',
        $data       = '',
        $name       = '',
        $colClass   = '',
        $dialogAttr = '',
        $colWidth   = '',
        $visible    = true,
        $orderable  = true,
        $searchable = true,
        $choosen    = true,
        $printable  = true
    )
    {
        $this->addField([
            "type"       => 'textarea',
            "title"      => $title,
            "data"       => $data,
            "name"       => $name,
            "class"      => $colClass,
            "width"      => $colWidth,
            "attr"       => $dialogAttr,
            "visible"    => $visible,
            "orderable"  => $orderable,
            "searchable" => $searchable,
            "choosen"    => $choosen,
            "printable"  => $printable,
        ]);

        return $this;
    }

    /**
     * @param string $title
     * @param string $data
     * @param string $name
     * @param string $colClass
     * @param string $dialogAttr
     * @param string $colWidth
     * @param bool $visible
     * @param bool $orderable
     * @param bool $searchable
     * @param bool $choosen
     * @param bool $printable
     * @return $this
     */
    function addInputNumber
    (
        $title      = '',
        $data       = '',
        $name       = '',
        $colClass   = '',
        $dialogAttr = '',
        $colWidth   = '',
        $visible    = true,
        $orderable  = true,
        $searchable = true,
        $choosen    = true,
        $printable  = true
    )
    {
        $this->addField([
            "type"       => 'number',
            "title"      => $title,
            "data"       => $data,
            "name"       => $name,
            "class"      => $colClass,
            "width"      => $colWidth,
            "attr"       => $dialogAttr,
            "visible"    => $visible,
            "orderable"  => $orderable,
            "searchable" => $searchable,
            "choosen"    => $choosen,
            "printable"  => $printable,
        ]);

        return $this;
    }

    /**
     * @param string $url
     * @param string $title
     * @param string $data
     * @param string $name
     * @param string $colLabel
     * @param string $colClass
     * @param string $dialogAttr
     * @param string $colWidth
     * @param bool $visible
     * @param bool $orderable
     * @param bool $searchable
     * @param bool $choosen
     * @param bool $printable
     * @return $this
     */
    function addAutocomplete
    (
        $url        = '',
        $title      = '' ,
        $data       = '',
        $name       = '' ,
        $colLabel   = '',
        $colClass   = '' ,
        $dialogAttr = '',
        $colWidth   = '',
        $visible    = true,
        $orderable  = true ,
        $searchable = true ,
        $choosen    = true,
        $printable  = true
    )
    {
        $this->addField([
            "type"       => 'autocomplete',
            "url"        => datatableLocalizeURL(Str::contains($url ,'autocomplete') ? $url : "autocomplete/$url"),
            "title"      => $title ,
            "data"       => $data,
            "name"       => $name ,
            "colLabel"   => $colLabel,
            "class"      => $colClass ,
            "width"      => $colWidth ,
            "attr"       => $dialogAttr,
            "visible"    => $visible,
            "orderable"  => $orderable,
            "searchable" => $searchable,
            "choosen"    => $choosen,
            "printable"  => $printable,
        ]);

        return $this;
    }

    /**
     * @param string $url
     * @param string $templete
     * @param string $title
     * @param string $data
     * @param string $name
     * @param string $colLabel
     * @param string $colClass
     * @param string $dialogAttr
     * @param string $colWidth
     * @param bool $visible
     * @param bool $orderable
     * @param bool $searchable
     * @param bool $choosen
     * @param bool $printable
     * @return $this
     */
    function addMultiAutocomplete
    (
        $url        = '',
        $templete   = '',
        $title      = '' ,
        $data       = '',
        $name       = '' ,
        $colLabel   = '',
        $colClass   = '' ,
        $dialogAttr = '',
        $colWidth   = '',
        $visible    = true,
        $orderable  = false,
        $searchable = true,
        $choosen    = true,
        $printable  = true
    )
    {
        $this->addField([
            "type"       => 'autocompleteMulti',
            "url"        => datatableLocalizeURL($url),
            "templete"   => $templete,
            "title"      => $title ,
            "data"       => $data,
            "name"       => $name ,
            "colLabel"   => $colLabel,
            "class"      => $colClass ,
            "width"      => $colWidth ,
            "attr"       => convertArrayToString($dialogAttr ,'multiple'),
            "visible"    => $visible,
            "orderable"  => $orderable,
            "searchable" => $searchable,
            "choosen"    => $choosen,
            "printable"  => $printable,
        ]);

        return $this;
    }

    /**
     * @param array $obj
     * @param string $title
     * @param string $data
     * @param string $name
     * @param string $colLabel
     * @param string $colClass
     * @param string $dialogAttr
     * @param string $colWidth
     * @param bool $visible
     * @param bool $orderable
     * @param bool $searchable
     * @param bool $choosen
     * @param bool $printable
     * @return $this
     */
    function addSelect
    (
        $obj        = [],
        $title      = '' ,
        $data       = '' ,
        $name       = '' ,
        $colLabel   = '',
        $colClass   = '' ,
        $dialogAttr = '',
        $colWidth   = '',
        $visible    = true,
        $orderable  = true ,
        $searchable = true ,
        $choosen    = true,
        $printable  = true
    )
    {
        $this->addField([
            "obj"        => $obj,
            "type"       => 'select',
            "title"      => $title ,
            "data"       => $data,
            "name"       => $name ,
            "colLabel"   => $colLabel,
            "class"      => $colClass ,
            "width"      => $colWidth ,
            "attr"       => $dialogAttr,
            "visible"    => $visible,
            "orderable"  => $orderable,
            "searchable" => $searchable,
            "choosen"    => $choosen,
            "printable"  => $printable,
        ]);

        return $this;
    }

    /**
     * @param string $title
     * @param string $data
     * @param string $name
     * @param string $colLabel
     * @param string $colClass
     * @param string $dialogAttr
     * @param string $colWidth
     * @param bool $visible
     * @param bool $orderable
     * @param bool $searchable
     * @param bool $choosen
     * @param bool $printable
     * @return $this
     */
    function addViewField
    (
        $title      = '' ,
        $data       = '' ,
        $name       = '' ,
        $colLabel   = '',
        $colClass   = '' ,
        $dialogAttr = '',
        $colWidth   = '',
        $visible    = true,
        $orderable  = true,
        $searchable = true,
        $choosen    = true,
        $printable  = true
    )
    {
        $this->addField([
            "type"       => '',
            "title"      => $title,
            "data"       => $data,
            "name"       => $name,
            "colLabel"   => $colLabel,
            "class"      => $colClass,
            "width"      => $colWidth,
            "attr"       => $dialogAttr,
            "visible"    => $visible,
            "orderable"  => $orderable,
            "searchable" => $searchable,
            "choosen"    => $choosen,
            "printable"  => $printable,

        ]);

        return $this;
    }

    /**
     * @param string $title
     * @param string $data
     * @param string $name
     * @param string $colClass
     * @param string $colWidth
     * @return $this
     */
    function addActionButton
    (
        $title = '' ,
        $data = '',
        $name = '' ,
        $colClass = 'center all' ,
        $colWidth = '40px'
    )
    {
        $this->addField([
            "type"       => 'button',
            "title"      => $title ,
            "data"       => $data,
            "name"       => $name ,
            "class"      => $colClass ,
            "width"      => $colWidth ,
            "visible"    => true,
            "orderable"  => false,
            "searchable" => false,
            "choosen"    => false,
            "printable"  => false
        ]);

        return $this;
    }

    /**
     * @param string $text
     * @param string $id
     * @param string $class
     * @param string $attr
     * @param string $placement
     * @return $this
     */
    function addButton(
        $text      = '',
        $id        = '',
        $class     = '',
        $attr      = '',
        $placement = 'footer'
    )
    {
        $this->_Button($text ,$id ,'button' ,$class ,$attr ,false ,$placement);

        return $this;
    }

    /**
     * @param string $text
     * @param string $id
     * @param string $class
     * @param string $attr
     * @param string $placement
     * @return $this
     */
    function addSubmit(
        $text      = '',
        $id        = '',
        $class     = '',
        $attr      = '',
        $placement = 'footer'
    )
    {
        $this->_Button($text ,$id ,'button' ,$class ,$attr ,false ,$placement);

        return $this;
    }

    /**
     * @param string $component
     * @param string $class
     * @return $this
     */
    function addChildRowDetail(
        $component = '',
        $class     = ''
    )
    {
        $this->addField([
            "data"           => null,
            "title"          => '<i class="icon-layers"></i>',
            "type"           => 'detail',
            "defaultContent" => '', //add default content to cell
            "className"      => "center all details-control $class",
            "width"          => '10px',
            "visible"        => true,
            "choosen"        => false,
            "orderable"      => false,
            "searchable"     => false,
            "printable"      => false,
        ]);

        $removeSpaces = autConvertString($component);

        $this->rowDetail = $removeSpaces;

        return $this;
    }

    /**
     * @param string $templete
     * @return $this
     */
    function editResponsiveRowDetailTemplete
    (
        $templete = ''
    )
    {
        $removeSpaces = autConvertString($templete);

        $this->customResponsiveTemplete = $removeSpaces;

        return $this;
    }

    /**
     * @param string $component
     * @param array $options
     * @return $this
     *
     * ---------
     *   desc
     * ---------
     *
     * $options = [
     *      ['selector' => '' , 'targetAttr' => '' ,'rowVal' => ''] ,[] , ...... ,[]
     * ]
     *
     */
    function addComponent
    (
        $component = '',
        $options   = []
    )
    {
        $isCustom = $this->_addComponent($component ,$this->isCustom);

        if($this->isCustom)
            $this->customHtml .= $isCustom;

        foreach ($options as $option)
        {
            $this->componentOptions[] = $option;
        }

        return $this;
    }

    /**
     * @param string $component
     * @param string $appendLocation
     * @param string $appendType => prependTo || appendTo
     * @return $this
     */
    function addBlade
    (
        $id,
        $component      = '',
        $appendLocation = 'body',
        $appendType     = 'appendTo'
    )
    {
        $this->blade[$id] = [
            'content'        => $component ,
            'appendLocation' => $appendLocation,
            'appendType'     => $appendType
        ];

        return $this;
    }

    /**
     * you can use js parameter: (param)
     *
     * @param $script
     * @return $this*
     */
    function onAdd($script){

        $this->events['onAdd'] = $this->replaceScript($script);

        return $this;
    }

    /**
     * you can use js parameter: (param)
     *
     * @param $script
     * @return $this
     */
    function onUpdate($script){

        $this->events['onUpdate'] = $this->replaceScript($script);

        return $this;
    }

    /**
     * you can use js parameter: (param)
     *
     * @param $script
     * @return $this
     */
    function onDelete($script){

        $this->events['onDelete'] = $this->replaceScript($script);

        return $this;
    }

    /**
     * you can use js parameter: (modal ,param)
     *
     * @param $script
     * @return $this
     */
    function onTableCreate($script) {

        $this->events['onTableCreate'] = $this->replaceScript($script);

        return $this;
    }
    /**
     * you can use js parameter: (modal ,param)
     *
     * @param $script
     * @return $this
     */
    function onLoad($script){

        $this->events['onLoad'] = $this->replaceScript($script);

        return $this;
    }

    /**
     * you can use js parameter: (modal ,param)
     *
     * @param $script
     * @return $this
     */
    function onModalOpen($script) {

        $this->events['modalOpen'] = $this->replaceScript($script);

        return $this;
    }

    /**
     * you can use js parameter: (modal ,param)
     *
     * @param $script
     * @return $this
     */
    function onModalClose($script) {

        $this->events['modalClose'] = $this->replaceScript($script);

        return $this;
    }

    /**
     * you can use js parameter: (param)
     *
     * @param $script
     * @return $this
     */
    function onModalAdd($script) {

        $this->events['modalAdd'] = $this->replaceScript($script);

        return $this;
    }

    /**
     * you can use js parameter: (row ,param)
     *
     * @param $script
     * @return $this
     */
    function onModalUpdate($script) {

        $this->events['modalUpdate'] = $this->replaceScript($script);

        return $this;
    }

    /**
     * you can use js parameter: (cont , row, param)
     *
     * @param $script
     * @return $this
     */
    function onRowDetailClick($script) {

        $this->events['rowDetailClick'] = $this->replaceScript($script);

        return $this;
    }

    /**
     * you can use js parameter: (cont ,param)
     *
     * @param $script
     * @return $this
     */
    function onTabClick($script) {

        $this->events['onTabClick'] = $this->replaceScript($script);

        return $this;
    }

    /**
     * @param $param
     * @return array
     */
    private function setDefaultAddField($param)
    {
        $paramDefault = [
            "type"            => '' ,
            "obj"             => '' ,
            "url"             => '' ,
            "templete"        => '' ,
            "title"           => '' ,
            "data"            => '' ,
            "name"            => '' ,
            'value'           => '' ,
            "colLabel"        => '' ,
            "class"           => '' ,
            "groupIcon"       => '' ,
            "groupClass"      => '' ,
            "width"           => '' ,
            "attr"            => '' ,
            "className"       => '' ,
            "defaultContent"  => '' ,
            "visible"         => true,
            "orderable"       => true,
            "searchable"      => true,
            "choosen"         => true,
            "printable"       => true,
        ];

        $paramDefault = array_merge($paramDefault ,$param);

        if(is_array($paramDefault['visible']))
        {
            if($paramDefault['visible']['visible'] == false)
            {
                $paramDefault['visible']    = false;
                $paramDefault['orderable']  = false;
                $paramDefault['searchable'] = false;
                $paramDefault['choosen']    = false;
                $paramDefault['printable']  = false;
            }
        }

        if(matchClass('none' ,$paramDefault['class']))
        {
            $paramDefault['orderable']  = false;
            $paramDefault['searchable'] = false;
            $paramDefault['choosen']    = false;
            $paramDefault['printable']  = false;
        }

        return $paramDefault;
    }

    function setLang($lang = 'en') {

        $this->params['lang'] = $lang;

        return $this;
    }
    /**
     * @param $value string|array
     * @return $this
     */
    function setDefaultValue($value)
    {
        $this->params['value'] = $value;

        return $this;
    }

    /**
     * @param $class string
     * @return $this
     */
    function setClass($class)
    {
        $this->params['class'] = $class;

        return $this;
    }

    /**
     * @param $name string
     * @return $this
     */
    function setName($name)
    {
        $this->params['name'] = $name;

        return $this;
    }

    /**
     * @param $attr string|array
     * @return $this
     */
    function setAttr($attr)
    {
        $this->params['attr'] = $attr;

        return $this;
    }

    function setPlaceholder($placeholder)
    {
        $this->params['placeholder'] = $placeholder;

        return $this;
    }

    /**
     * @param array $param
     */
    protected function addField
    (
        $param = [
            "type"            => '' ,
            "obj"             => '' ,
            "url"             => '' ,
            "templete"        => '' ,
            "title"           => '' ,
            "data"            => '' ,
            "name"            => '' ,
            'value'           => '' ,
            "colLabel"        => '' ,
            "class"           => '' ,
            "groupIcon"       => '' ,
            "groupClass"      => '' ,
            "width"           => '' ,
            "attr"            => '' ,
            "className"       => '' ,
            "defaultContent"  => '' ,
            "visible"         => true,
            "orderable"       => true,
            "searchable"      => true,
            "choosen"         => true,
            "printable"       => true,
        ]
    )
    {
        $param = $this->setDefaultAddField($param);

        $column = collect();

        $choosen = $this->isVisible($this->locale ,$param["visible"] ,$param["choosen"] ,$param["class"]);

        $param['class_attr'] = $this->dialogClassAttr($param["class"] ,$param["attr"] ,$param["type"]);

        $data = empty($param['colLabel']) ? $param["data"] : $param['colLabel'];

        $data = empty($param['templete']) ? $data : $param['templete'];

        $column->put('data'       ,$data);
        $column->put('name'       ,$param["name"]);
        $column->put('class'      ,$param['class_attr']['class_table']);
        $column->put('width'      ,$param["width"]);
        $column->put('visible'    ,$choosen["visible"]);
        $column->put('orderable'  ,$param["orderable"]);
        $column->put('searchable' ,$param["searchable"]);
        $column->put('printable'  ,$param["printable"]);
        $column->put('className'  ,$param["className"]);
        $column->put('defaultContent',$param["defaultContent"]);

        array_push($this->columns,$column);

        $this->dataTable->put('columns',$this->columns);

        $configChoosen = config('datatable.choosen');

        $choosen = $param["choosen"] ? '' : $configChoosen;

        $this->FillTable($param ,$choosen);

        $this->FillDialogDatatable($param ,$choosen);

        $this->index += 1;
    }

    /**
     * @param $class
     * @param $attr
     * @param $type
     * @return array
     */
    protected function dialogClassAttr($class , $attr , $type)
    {
        $class_dialog = '';

        $attr = convertArrayToString($attr);
        $attr = empty($this->params['attr']) ? $attr : convertArrayToString($this->params['attr'] ,$attr);

        // add en/ar class to dialog
        $langs = implode("|", $this->langs);
        if(matchClass($langs ,$class ,$result))
            $class_dialog = "$class_dialog {$result[0]}";

        // add required class to dialog
        if(matchClass('required' ,$class))
            $class_dialog = "$class_dialog required";

        // add req class to dialog
        if(matchClass('req' ,$class))
            $class_dialog = "$class_dialog req";

        // add req class to dialog
        if(matchClass('text-editor' ,$class)) {
            $class_dialog = "$class_dialog datatable-text-editor";
            $attr = "$attr data-resize=true data-resize-type=vertical";
        }

        if($type == 'number')
        {
            if(matchClass('spinner' ,$class))
                $class_dialog = "$class_dialog spinner";
            else
                $class_dialog = "$class_dialog none-spinner";
        }

        if(matchClass('number' ,$class))
             $class_dialog = "$class_dialog number";

        $replacement = '';
        // add other class with d alias to dialog ** add this classes to replacement str
        if(preg_match_all('/\b(?<![\S])(d:[\w\d-]+)(?![\S])\b/',$class,$results,PREG_PATTERN_ORDER)) {
            foreach ($results as $index => $result)
            {
                if ($index == 0)
                    foreach ($result as $item)
                    {
                        $replacement = "$replacement|$item";
                        $item = preg_replace('/\b(?<![\S])(d:)\b/','',$item);
                        $class_dialog = "$class_dialog $item";
                    }
            }
        }

        // add attr autocomplete to attr str
        if($type == 'text' || $type == 'number' || $type == 'group')
        {
            if(matchClass('autocomplete' ,$class))
                $attr = "$attr autocomplete = 'on'";
            else
                $attr = "$attr autocomplete = 'off'";
        }

        // remove class dialog from string
        $replacement = "req|required|number|en|ar|autocomplete|spinner|text-editor{$replacement}";

        // just class table
        $class_table = trim(preg_replace("/\b(?<![\S])($replacement)(?![\S])\b/",'',$class));

        //relation
        if($this->relation_key != '')
        {
            $relation = $this->organizeRelation($this->relation_key);

            $attr = "$attr data-relation = $relation";
        }

        // return all
        return ['class_dialog' => trim($class_dialog) ,'class_table' => trim($class_table) ,'attr' => trim($attr)];
    }

    /**
     * @param $relationParam
     * @return string
     */
    private function organizeRelation($relationParam)
    {
        $rel = "";
        foreach (explode('.' ,$relationParam) as $index => $relation)
        {
            if($index == 0)
                $rel .= $relation;
            else
                $rel .= "[$relation]";
        }

        return $rel;
    }

    /**
     * @param $param
     * @param $choosen
     */
    function FillTable($param , $choosen)
    {
        $this->addTableColumn($param ,$choosen);
    }

    /**
     * @param $param
     * @param $choosen
     */
    function FillDialogDatatable($param, $choosen)
    {
        $class_attr = $param['class_attr'];

        $id = preg_replace('/.+\./', '', $param["data"]);
        $array    = shortIfElse($param["type"] == 'autocompleteMulti' , "[]" ,"");
        $relation = $this->organizeRelation($this->relation_key);
        $name     = shortIfElse($this->relation_key != '' ,"{$relation}[$id]$array" ,"$id{$array}");
        $name     = shortIfElse(empty($this->params['name']) ,$name ,$this->params['name']);
        $id       = shortIfElse($this->relation_key != '' ,$param["data"] ,$id);

        $class  = shortIfElse(empty($this->params['class']) ,$class_attr['class_dialog'] ,"{$this->params['class']} {$class_attr['class_dialog']}");

        switch ($param["type"]) {

            case 'hidden' : {
                if (!$this->optionDatatableConfig['disableDialog'])
                    $this->_HiddenInput($id, $name, $param['value'], 'hidden', $class, $class_attr['attr'], $this->isCustom);
            }; break;

            case 'text' : {
                if (!$this->optionDatatableConfig['disableDialog'])
                    $isCustom = $this->_Input($param["title"], $id, $name, $this->params['value'], 'text', $class, $class_attr['attr'], $this->isCustom);
            }; break;

            case 'date' :
            case 'time' :
            case 'datetime-local' :
            case 'datetime' :
            case 'month' :
            case 'week' :
            case 'email' :
            case 'url' : {
                if (!$this->optionDatatableConfig['disableDialog'])
                    $isCustom = $this->_Input($param["title"], $id, $name, $this->params['value'], $param["type"], $class, $class_attr['attr'], $this->isCustom);
            }; break;

            case 'password' : {
                if (!$this->optionDatatableConfig['disableDialog'])
                    $isCustom = $this->_InputPassword($param["title"], $id, $name, 'password', $class, $class_attr['attr'], $this->isCustom);
            }; break;

            case 'group' : {
                if (!$this->optionDatatableConfig['disableDialog'])
                    $isCustom = $this->_InputGroup($param["title"], $id, $name, $this->params['value'], 'text', $class, $param['groupIcon'], $param['groupClass'], $class_attr['attr'], $this->isCustom);
            }; break;

            case 'textarea' : {
                if (!$this->optionDatatableConfig['disableDialog'])
                    $isCustom = $this->_TextArea($param["title"], $id, $name, $this->params['value'], $class, $class_attr['attr'], $this->isCustom);
            }; break;

            case 'number' : {
                if (!$this->optionDatatableConfig['disableDialog'])
                    $isCustom = $this->_InputNumber($param["title"], $id, $name, $this->params['value'], 'number', $class, $class_attr['attr'], $this->isCustom);
            }; break;

            case 'select': {
                if (!$this->optionDatatableConfig['disableDialog'])
                    $isCustom = $this->_Select($param['obj'], $param["title"], $id, $name, $param['colLabel'], $class, $class_attr['attr'], $this->isCustom);
            }; break;

            case 'autocomplete' :
            case 'autocompleteMulti' : {
                if (!$this->optionDatatableConfig['disableDialog'])
                    $isCustom = $this->_Autocomplete($param['url'], $param["title"], $id, $name, $this->params['value'], $param['colLabel'], $class, $class_attr['attr'], 'body' /* "#{$this->id}-modal" */, $this->isCustom);
            }; break;
        }

        if ($this->isCustom)
            $this->customHtml .= $isCustom;

        // clear param
        foreach($this->params as $index => $param)
            $this->params[$index] = '';
    }

    /**
     * @param $locale
     * @param $visible
     * @param $choosen
     * @param $class
     * @return array
     */
    protected function isVisible($locale , $visible , $choosen, $class)
    {
        $langs = $this->langs;

        foreach ($langs as $index => $lang)
            if($locale == $lang)
                unset($langs[$index]);

        $hiddenLang = implode("|", $langs);

        if($choosen)
        {
            if(matchClass($hiddenLang ,$class)) {

                $visible = false;
            }
        }

        return ['visible' => $visible ,'choosen' => $choosen] ;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    function exceptColumn()
    {
        $exceptColumns = collect();

        $exceptColumns->push([
            'targets'    => 0,
            'visible'    => false,
            'orderable'  => false,
            'searchable' => false
        ]);

        return $exceptColumns;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function setLanguage()
    {
        $lang = collect();

        $lang->put('lengthMenu',trans('datatable::table.lengthMenu'));
        $lang->put('emptyTable',trans('datatable::table.emptyTable'));
        $lang->put("processing", ''); //Processing...
        $lang->put("loadingRecords", ''); //Loading...
        $lang->put("zeroRecords", trans('datatable::table.zeroRecords'));
        $lang->put("info",trans('datatable::table.info'));
        $lang->put('infoEmpty',trans('datatable::table.infoEmpty'));
        $lang->put('infoFiltered',trans('datatable::table.infoFiltered'));
        $lang->put('search','');
        $lang->put('searchPlaceholder',trans('datatable::table.searchPlaceholder'));
        $lang->put('paginate',[
            'first'    => trans('datatable::table.paginate.first'),
            "previous" => trans('datatable::table.paginate.previous'),
            "next"     => trans('datatable::table.paginate.next'),
            "last"     => trans('datatable::table.paginate.last'),
        ]);
        $lang->put('buttons',[
            'copyTitle'   => trans('datatable::table.buttons.copy.copyTitle'),
            'copySuccess' => [
                '_' => trans('datatable::table.buttons.copy.copySuccess.all'),
                1  => trans('datatable::table.buttons.copy.copySuccess.one')
            ]
        ]);

        return $lang;
    }

    /**
     * @param array $buttons
     * @param array $except
     * @return $this
     */
    function addNavButton($buttons = [], $except = [])
    {
        $buttonResult = collect();

        if(!empty($buttons))
        {
            $this->tableButtons = $buttons;
        }

        if(!empty($except))
        {
            $buttons = collect($this->tableButtons)->filter(function($button) use($except) {

                foreach ($except as $exceptButton)
                {
                    if($exceptButton == $button)
                    {
                        $done =  false;

                        break;
                    }
                    else
                    {
                        $done = true;
                    }
                }

                return $done;
            });

            $this->tableButtons = $buttons;
        }


        foreach ($this->tableButtons as $button) {

            switch ($button) {

                case 'add' : {

                    $addIcon = config('datatable.icon.add');

                    $buttonResult->push([
                        'text'      => "<i class='$addIcon'></i>",
                        'titleAttr' => trans('datatable::table.new_row'),
                        'className' => 'button-style button-plus',
                        'action'    => 'buttons_action_plus'
                    ]);

                } break;

                case 'reload' : {

                    $refreshIcon = config('datatable.icon.reload');

                    $buttonResult->push([
                        'text' => "<i class='$refreshIcon'></i>",
                        'titleAttr' => trans('datatable::table.reload'),
                        'className' => 'button-style button-reload',
                        'action' => 'buttons_action_reload'
                    ]);

                } break;

                case 'code' : {

                    if(config('datatable.isDebug')) {

                        $codeIcon = config('datatable.icon.code');

                        $buttonResult->push([
                            'text' => "<i class='$codeIcon'></i>",
                            'titleAttr' => trans('datatable::table.code'),
                            'className' => 'button-style button-code',
                            'action' => 'buttons_action_code'
                        ]);
                    }

                } ; break;

                case 'destroy' : {

                    if(config('datatable.isDebug')) {

                        $destroyIcon = config('datatable.icon.destroy');

                        $buttonResult->push([
                            'text'      => "<i class='$destroyIcon'></i>",
                            'titleAttr' => trans('datatable::table.destroy'),
                            'className' => 'button-style button-destroy',
                            'action'    => 'buttons_action_destroy'
                        ]);
                    }

                } ; break;

                case 'choosen' : {

                    $choosenIcon = config('datatable.icon.choosen');

                    $configChoosen = config('datatable.choosen');

                    $buttonResult->push([
                        'extend'    => 'colvis',
                        'text'      => "<i class='$choosenIcon'></i>",
                        'titleAttr' => trans('datatable::table.column_visibility'),
                        'className' => 'button-style',
                        'columns'   => ":not(.$configChoosen)"
                    ]);

                } break;

                case 'export' : {

                    $exportIcon = config('datatable.icon.export');

                    $pdfIcon  = config('datatable.icon.pdf');
                    $transPdf = trans('datatable::table.pdf');

                    $printIcon  = config('datatable.icon.print');
                    $transPrint =  trans('datatable::table.print');

                    $csvIcon = config('datatable.icon.csv');
                    $transCsv = trans('datatable::table.csv');

                    $excelIcon = config('datatable.icon.excel');
                    $transExcel = trans('datatable::table.excel');

                    $copyIcon = config('datatable.icon.copy');
                    $transCopy = trans('datatable::table.copy');

                    $buttonResult->push([
                        'extend'    => 'collection',
                        'text'      => "<i class='$exportIcon'></i>",
                        'titleAttr' => trans('datatable::table.export'),
                        'className' => 'buttons-export button-style hidden-xs',
                        'buttons'   => [
                            [
                                'extend'    => 'print',
                                'autoPrint' => false,
                                'text'      => "<span><i class='$printIcon'></i> $transPrint</span>",
                                'className' => 'buttons-print',
                                'title'         => '',
                                'message'       => '',
                                'exportOptions' => [
                                    'columns'   => '.printable',
                                ],
                                //'customize' => 'datatable_print_customize',
                                //'action'    => 'event_print_button'
                            ],
                            [
                                'extend'    => 'csvHtml5',
                                'text'      => "<span><i class='$csvIcon'></i> $transCsv</span>",
                                'className' => 'buttons-csv',
                                //'action'    => 'event_csv_button'

                            ],
                            [
                                'extend'    => 'excelHtml5',
                                'text'      => "<span><i class='$excelIcon'></i> $transExcel</span>",
                                'className' => 'buttons-excel',
                                //'action'    => 'event_excel_button'

                            ],
                            [
                                'extend'    => 'pdfHtml5',
                                'text'      => "<span><i class='$pdfIcon'></i> $transPdf</span>",
                                'className' => 'buttons-pdf',
                                //'action'    => 'event_pdf_button'
                            ],
                            [
                                'extend'    => 'copyHtml5',
                                'text'      => "<span><i class='$copyIcon'></i> $transCopy</span>",
                                'className' => 'buttons-pdf',
                                //'action'    => 'event_copy_button'
                            ]
                        ],
                    ]);

                } break;
            }
        }

        $this->dataTable->put('buttons',$buttonResult);

        return $this;
    }

    /**
     * @param $title
     * @param $icon
     * @param $class
     * @param $attr
     * @return $this
     */
    function addCustomNavButton($title , $icon , $class , $attr)
    {
        $this->globalScript .= $this->addCustomNavButtonScript($title ,$icon ,$class ,$attr);

        return $this;
    }

    /**
     * @return mixed|string
     */
    protected function setButtonPosition()
    {
        $ButtonPosition = config("datatable.button_position");

        if($this->optionDatatableConfig['removeElement'])
            $ButtonPosition =
                "B tr"
            ;

        $removeSomeElement = $this->optionDatatableConfig['removeSomeElement'];

        if(!empty($removeSomeElement))
        {
            $button = 'B';
            $length = 'l';
            $info   = 'i';
            $search = 'f';
            $paging = 'p';

            foreach($removeSomeElement as $index => $item)
            {
                switch ($item)
                {
                    case 'b' : $button = '';break;
                    case 'l' : $length = '';break;
                    case 'i' : $info   = '';break;
                    case 's' : $search = '';break;
                    case 'p' : $paging = '';break;
                }
            }

            $ButtonPosition = "$button<'row'<'col-lg-4 datatable-pull-left'$length><'col-lg-4 datatable-pull-right'$search>>tr<'row'<'col-lg-4 datatable-pull-left'$info><'col-lg-6 datatable-pull-right'$paging>>";
        }

        return $ButtonPosition;
    }

    /**
     * @param $dataTable
     * @return string
     */
    protected function initScript($dataTable)
    {
        $spinners               = config("datatable.spinners");
        $multiModal             = config('datatable.multiModel') ? 'true' : 'false';
        $tabAnimation           = config('datatable.tabAnimation');
        $event                  = config('datatable.event');
        $onLoadConfig           = $this->replaceScript($event['onLoad']());
        $onModalOpenConfig      = $this->replaceScript($event['modalOpen']());
        $onModelCloseConfig     = $this->replaceScript($event['modalClose']());
        $onModalAddConfig       = $this->replaceScript($event['modalAdd']());
        $onModalUpdateConfig    = $this->replaceScript($event['modalUpdate']());
        $onTabClickConfig       = $this->replaceScript($event['onTabClick']());
        $onRowDetailClickConfig = $this->replaceScript($event['onRowDetailClick']());
        $onDestroyConfig        = $this->replaceScript($event['onDestroy']());
        $onTableCreateConfig    = $this->replaceScript($event['onTableCreate']());

        $dir                      = $this->dir;
        $disableDialog            = $this->optionDatatableConfig['disableDialog'] ? 'true' : 'false';
        $scrollX                  = $this->optionDatatableConfig['scrollX'] ? 'true' : 'false';
        $scrollY                  = $this->optionDatatableConfig['scrollY'] ? 'true' : 'false';
        $url                      = datatableLocalizeURL($this->url);
        $exportUrl                = datatableLocalizeURL("datatable/$this->model/export/table");
        $dialog                   = trans('datatable::table.dialog');
        $save                     = trans('datatable::table.save');
        $sortable                 = $this->optionDatatableConfig['sortable'] ? 'true' : 'false';
        $rowDetail                = $this->rowDetail != '' ? $this->rowDetail : '';
        $responsive               = $this->optionDatatableConfig['responsive'] ? 'true' : 'false';
        $customResponsiveTemplete = $this->customResponsiveTemplete;
        $usedComponent            = $this->optionDatatableConfig['usedComponent'] ? 'true' : 'false';
        $componentOptions         = !empty($this->componentOptions) ? collect($this->componentOptions) : collect([]);

        $swal = array(
            "ok"                => trans('datatable::table.swal.ok'),
            "title"             => trans('datatable::table.swal.title'),
            "text"              => trans('datatable::table.swal.text'),
            "type"              => trans('datatable::table.swal.type'),
            "confirmButtonText" => trans('datatable::table.swal.confirmButtonText'),
            "cancelButtonText"  => trans('datatable::table.swal.cancelButtonText'),
            "success"           => array(
                "text"    => trans('datatable::table.swal.success.text'),
                "message" => trans('datatable::table.swal.success.message'),
            ),
            "cancleSafe"        => array(
                "text"    => trans('datatable::table.swal.cancleSafe.text'),
                "message" => trans('datatable::table.swal.cancleSafe.message'),
            )
        );

        $oper = trans('datatable::table.oper');

        $script  = "
            <script class='datatable'>
                
                $(document).ready(function () {
      
                     aut_datatable_CreateNewTable({ 
                         url : '$url',
                         export_url : '$exportUrl',
                         dir : '$dir',
                         json_object   : $dataTable,
                         tab_animation : '$tabAnimation',
                         multi_modal   : $multiModal,
                         row_detail    : function(row) {
                            return $rowDetail; 
                         }, 
                         responsive: $responsive,
                         responsive_templete: function(col) {
                            return $customResponsiveTemplete;
                         },
                         component : {
                            used    : $usedComponent,
                            options : $componentOptions
                         },
                         model : '$this->model',
                         ids : {
                             table   : '#$this->id',
                             modal   : '#$this->id-modal',
                             wrapper : '#{$this->id}_wrapper'
                         },
                         lang : {
                            save : '$save',
                            oper : {
                                success : '{$oper['success']}',
                                error   : '{$oper['error']}',
                                successOrder    : '{$oper['successOrder']}',
                            },
                            swal : {
                                ok                :  '{$swal['ok']}',
                                title             :  '{$swal['title']}',
                                text              :  '{$swal['text']}',
                                confirmButtonText :  '{$swal['confirmButtonText']}',
                                cancelButtonText  :  '{$swal['cancelButtonText']}',
                                success           :  {
                                    text    : '{$swal['success']['text']}',
                                    message : '{$swal['success']['message']}',
                                },
                                cancleSafe : {
                                    text    : '{$swal['cancleSafe']['text']}',
                                    message : '{$swal['cancleSafe']['message']}',
                                }
                            },
                         },
                         spinners : {
                             type     : '{$spinners['type']}',
                             overlay  : '{$spinners['overlay']}',  
                         },
                         modal : {
                             add_btn : '{$dialog['add']} $this->dialogCaption',
                             update_btn :'{$dialog['update']} $this->dialogCaption',
                         },
                         setting : {
                             disable_dialog : $disableDialog,
                             sortable : $sortable,
                             scrollX : $scrollX,
                             scrollY: $scrollY,
                         },
                         global_script : function() {
                            {$this->globalScript}
                         },
                         events: {
                             on_add : function(param) {
                                {$this->events['onAdd']}
                             },
                             on_update : function(param) {
                                {$this->events['onUpdate']}
                             },
                             on_delete : function(param) {
                                 {$this->events['onDelete']}
                             },
                             'on_table_create' : function(modal ,param) {
                                   
                                 {$this->events['onTableCreate']}
                                 
                                 {$onTableCreateConfig}
                             },
                             on_load : function(modal ,param) {
                                 
                                 {$this->events['onLoad']}
                                 
                                 {$onLoadConfig}
                             },
                             modal_open : function(modal ,param) {
                                 
                                 {$this->events['modalOpen']}
                             
                                 {$onModalOpenConfig}
                             }, 
                             modal_close : function(modal ,param) {
                                 
                                 {$this->events['modalClose']}
                                 
                                 {$onModelCloseConfig}
                             },
                             modal_add : function(param) {
                                 
                                 {$this->events['modalAdd']}
                                 
                                 {$onModalAddConfig}
                             },
                             modal_update : function(row ,param) {
                                 
                                 {$this->events['modalUpdate']}
                                 
                                 {$onModalUpdateConfig}
                             },
                             row_detail_click : function(cont ,row ,param) {
                                 
                                 {$this->events['rowDetailClick']}
                                 
                                 {$onRowDetailClickConfig}
                             },
                             on_tab_click : function(cont ,param) {
                                 
                                {$this->events['onTabClick']}
                                                                
                                {$onTabClickConfig}
                             },
                             'on_destroy' : function() {
                                 
                                 {$onDestroyConfig}
                             }
                         }
                     });
                });
            </script>";

        return $script;
    }

    /**
     * @return array
     */
    function render()
    {
        $this->customHtml = '';

        if($this->optionDatatableConfig['responsive'])
            if($this->customResponsiveTemplete == '')
                throw new Exception('opsss !!! sorry you must fill your custom responsive templete');

        $dialog = $this->optionDatatableConfig['disableDialog'] == true ? '' : $this->renderDialog("{$this->id}-modal");

        return [
            "table"    => $this->renderTable($this->id),
            "dialog"   => $dialog,
            "script"   => $this->initScript($this->dataTable),
            "blade"    => $this->blade
        ];
    }

}