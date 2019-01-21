<?php

namespace Aut\DataTable\Traits;

trait Table
{
    protected $header = "";

    protected $filter = "";

    protected $count = 0;

    protected function addTableColumn($param ,$choosen)
    {
        $printable = $param['printable']  ? "printable" : '';

        $this->header .= "<th class='$choosen $printable' style='max-width: {$param['width']};'>{$param['title']}</th>";

        if($this->optionDatatableConfig['filter']) {

            $transFilter = trans('datatable::table.filter');

            if(!in_array($param["type"],['index','hidden','button' ,'detail'])) {

                switch ($param["type"]) {

                    case 'select' : {
                        $option = "<option></option>";
                        foreach ($param['obj'] as $key => $value)
                            $option .= "<option value='$key'>$value</option>";

                        $this->filter .="
                            <th>
                                <select class='form-control filter-select datatable-select' style='width: 100%;' data-placeholder='{$param['title']}'>
                                    $option
                                </select>
                            </th>
                        ";
                    } break;

                    default : {
                        $this->filter .="<th><input type='text' placeholder='$transFilter {$param['title']}' class='form-control filter-Input'></th>";
                    } break;
                }
            }
            else {
                $this->filter .="<th></th>";
            }
        }

        $this->count += 1;
    }

    protected function renderTable($id = 'datatable', $class = 'table table-striped table-hover')
    {
        $buttonResponsive =  $this->optionDatatableConfig['responsive']
        ? "<tr><th class='table-button' colspan='$this->count'></th></tr>" : "";

        $filter = $this->optionDatatableConfig['filter']
        ? "<tr class='filter-datatable-cont'>$this->filter</tr>" : "";

        $footer = $this->optionDatatableConfig['responsive'] || $this->optionDatatableConfig['filter']  ?
        "<tfoot>{$filter}{$buttonResponsive}</tfoot>" : "";

        $sortable = $this->optionDatatableConfig['sortable'] == true ? "class='sortable'" : "";

        $table = "
            <table id='$id' class='$class custom-table' style='width: 100%;'>
                <thead>
                    <tr>
                        $this->header
                    </tr>
                </thead>
                <tbody $sortable>
                </tbody>
                $footer
            </table>";

        return $table;
    }
}