<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 10/16/2016
 * Time: 2:33 PM
 */

namespace Aut\DataTable\Traits;

use Datatables;

trait QueryDataTable
{
    protected $query;

    protected $escapeColumns = [];

    /**
     * @param $query
     * @return $this
     */
    function queryDatatable($query)
    {
        $this->query = Datatables::of($query);

        $this->queryIndexColumn();

        return $this;
    }

    /**
     * @param $model
     * @return $this
     */
    function queryDatatableEloquent($model)
    {
        $this->query = Datatables::eloquent($model);

        $this->queryIndexColumn();

        return $this;
    }

    /**
     * @param string $tableId
     * @return $this
     */
    function queryConfig($tableId = '')
    {
        $this->id = $tableId;

        $this->langs  = \LaravelLocalization::getSupportedLanguagesKeys();

        return $this;
    }

    /**
     * @return $this
     */
    function queryIndexColumn()
    {
        $query = $this->query;

        $query->addIndexColumn();

        return $this;
    }

    /**
     * @param $colKey
     * @param \Closure $func
     * @return $this
     */
    function queryAddColumn($colKey, \Closure $func)
    {
        $query = $this->query;

        $query->addColumn($colKey, $func);

        return $this;
    }

    /**
     * @param $colKey
     * @param string $relation
     * @param string $target
     * @return $this
     */
    function queryMultiAutocompleteTemplete($colKey, $relation = '' , $target = '')
    {
        $query = $this->query;

        $query->addColumn($colKey, function ($item) use ($relation ,$target) {

            $li = '';

            foreach ($item->$relation as $item)
                $li .= "<li>".colValue($target ,$item);

            return $li;
        });

        return $this;
    }

    /**
     * @param $colKey
     * @param \Closure $func
     * @return $this
     */
    function queryEditColumn($colKey, \Closure $func)
    {
        $query = $this->query;

        $query->editColumn($colKey, $func);

        return $this;
    }

    /**
     * @param string $id
     * @param \Closure|null $func
     * @return $this
     */
    function queryUpdateButton($id = 'id', \Closure $func = null)
    {
        $query = $this->query;

        $query->addColumn('update', function ($item) use ($id, $func) {

            $updateIcon = config("datatable.icon.update");

            if ($func) {
                return call_user_func($func, $item);
            }

            return "<span data-key='{$item->$id}' data-toggle='modal' data-target='#$this->id-modal' class='dialog-update datatable-icon-hand'><i class='$updateIcon'></i></span>";
        });

        return $this;
    }

    /**
     * @param string $id
     * @param array $parentKey
     * @param \Closure|null $func
     * @return $this
     */
    function queryDeleteButton($id = 'id', $parentKey = [], \Closure $func = null)
    {
        $query = $this->query;

        $query->addColumn('delete', function ($item) use ($id, $parentKey, $func) {

            $deleteIcon = config("datatable.icon.delete");

            if (!empty($parentKey)) {
                $parent_id = $item;

                foreach ($parentKey as $index => $obj) {
                    $parent_id = $parent_id->$obj;
                }
            }

            if ($func) {
                return call_user_func($func, $item);
            }

            $parent_id = !empty($parentKey) ? "data-parent-key='{$parent_id}'" : "";

            return "<span data-key='{$item->$id}' $parent_id class='dialog-delete datatable-icon-hand'><i class='$deleteIcon'></i></span>";
        });

        return $this;
    }

    /**
     * @param $cols
     * @param \Closure $func
     * @return $this
     */
    function queryMultiColumn($cols , \Closure $func)
    {
        $query = $this->query;

        foreach ($cols as $index => $col)
        {
            $query->addColumn($col ,$func);
        }

        return $this;
    }

    /**
     * @param array $cols
     * @return $this
     */
    function queryMultiLang($cols = [])
    {
        $query = $this->query;

        foreach ($this->langs as $lang)
        {
            foreach ($cols as $index => $col)
            {
                $query->addColumn("{$col}_{$lang}" ,function ($item) use($index ,$col ,$lang) {

                    $property = snake_case("lang_$col");
                    $relation = snake_case($index).'->'.$property;

                    if (is_numeric($index))
                        return isset($item->$property[$lang]) ? $item->$property[$lang]->text : '';
                    else
                        return isset(colValue($relation ,$item)[$lang]) ? colValue($relation ,$item)[$lang]->text : '';
                });
            }
        }

        return $this;
    }

    /**
     * @param string $colKey
     * @param string $rowId
     * @param string $icon
     * @param string $class
     * @param string $attr
     * @return $this
     */
    function queryCustomButton($colKey = '', $rowId = '', $icon = '', $class = '', $attr = '')
    {
        $query = $this->query;

        $query->addColumn($colKey, function ($item) use($rowId ,$class ,$icon ,$attr) {

            if(preg_match_all('/{[a-z-_>]+}/',$attr,$results,PREG_PATTERN_ORDER)) {

                foreach ($results[0] as $result)
                {
                    $property = substr($result, 1, -1);

                    $propArr=explode('->',$property);

                    $obj = $item;

                    foreach ($propArr as $prop)
                    {
                        $obj = $obj->$prop;
                    }

                    $attr = preg_replace("/$result/" ,$obj ,$attr);
                }
            }

            if(preg_match("/href/" ,$attr)) {
                $tag  = 'a';
                $hand = '';
            }
            else {
                $tag = 'span';
                $hand = 'datatable-icon-hand';
            }

            return "<$tag data-key='{$item->$rowId}' class='$hand $class' $attr><i class='{$icon}'></i></span>";
        });

        return $this;
    }

    /**
     * @param $alias
     * @param $cols
     * @return $this
     */
    function queryCombineColumn($alias , $cols)
    {
        $query = $this->query;

        $query->editColumn($alias, function ($item) use($cols) {

            $result = '';

            foreach ($cols as $index => $col)
            {
                $result .= $item->{$col};

                if($index != count($cols)-1)
                    $result .= ' ';
            }

            return $result;
        });

        return $this;
    }

    /**
     * @param $alias
     * @param $dbCol
     * @return $this
     */
    function queryFilterColumn($alias, $dbCol)
    {
        $query = $this->query;

        $query->filterColumn($alias, function(\Eloquent $query, $keyword) use ($dbCol) {

            $query->whereRaw("$dbCol like ?", ["%{$keyword}%"]);
        });

        return $this;
    }

    /**
     * @param $alias
     * @param \Closure $func
     * @return $this
     */
    function queryCustomFilterColumn($alias, \Closure $func)
    {
        $query = $this->query;

        $query->filterColumn($alias, $func);

        return $this;
    }

    /**
     * @param array $columns
     * @return $this
     */
    function queryEscapeColumns($columns =[])
    {
        $this->escapeColumns = $columns;

        return $this;
    }

    function dd()
    {
        dd($this->query);
    }

    function ddQuery()
    {
        dd($this->query->getQueryBuilder());
    }

    function ddQuerySql()
    {
        dd($this->query->getQueryBuilder()->toSql());
    }

    /**
     * @param bool $bool
     * @return mixed
     */
    function queryRender($bool = true)
    {
        $query = $this->query;

        $query->escapeColumns($this->escapeColumns);
        // temp
        $bool = true;

        return $query->make($bool);
    }
}