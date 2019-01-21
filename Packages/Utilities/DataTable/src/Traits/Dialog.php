<?php

namespace Aut\DataTable\Traits;

trait Dialog
{
    protected $dialogCaption = "";

    protected $dialogBody = "";

    protected $dialogFooter = "";

    /**
     * @param $id
     * @return string
     */
    protected function renderDialog($id)
    {
        $dialogWidth = !empty($this->optionDatatableConfig['dialogWidth'])
            ? "min-width : {$this->optionDatatableConfig['dialogWidth']};"
            : '';

        $form_class = config('datatable.dialog_form_class');

        $form_attr = config('datatable.dialog_form_attr');

        $tabAnimation = config('datatable.tabAnimation');

        if($this->optionDatatableConfig['withTab'])
            $continer = view('datatable::_tab',['id' => $this->id ,'tabAnimation' => $tabAnimation,'tabs' => $this->tabs])->render();
        else
            $continer = $this->dialogBody;

        $dialog =  view('datatable::_modal',[
            'id'                => $id,
            'table'             => $this->model,
            'dialogWidth'       => $dialogWidth,
            'form_class'        => "$form_class {$this->optionDatatableConfig['formClass']}",
            'form_attr'         => "$form_attr {$this->optionDatatableConfig['formAttr']}",
            'continer'          => $continer,
            'dialogFooter'      => $this->dialogFooter,
            'withTabs'          => $this->optionDatatableConfig['withTab'],
            'enableGridSystem'  => $this->optionDatatableConfig['gridSystem'],
            'gridSystem'        => $this->gridSystem
        ])->render();

        return $dialog;
    }

    /**
     * @param $html
     * @param $isCustom
     * @param string $stringCont
     * @return mixed
     */
    function checkReturnValue($html , $isCustom , $stringCont = 'dialogBody')
    {
        if($isCustom)
        {
            return $html;
        }
        else
        {
            if($this->optionDatatableConfig['withTab'])
            {
                $this->partOfContent .= $html;

                $this->tab['content'] = $this->partOfContent;
            }
            else
                $this->$stringCont .= $html;
        }
    }

    private function setDefaultDialogEntry($param)
    {
        $paramDefault = [
            'component'  => '',
            'id'         => '',
            'name'       => '',
            'title'      => '',
            'type'       => '',
            'value'      => '',
            'class'      => '',
            'attr'       => '',
            'groupClass' => '',
            'groupIcon'  => '',
            'text'       => '',
            'stringCont' => 'dialogBody',
            'url'        => '',
            'options'    => [],
            'colLabel'   => '',
            'target'     => '',
            'custom'     => false,
        ];

        $paramDefault = array_merge($paramDefault ,$param);

        return $paramDefault;
    }

    function _dialogEntry($param = [
        'component'  => '',
        'id'         => '',
        'name'       => '',
        'title'      => '',
        'type'       => '',
        'value'      => '',
        'class'      => '',
        'attr'       => '',
        'groupClass' => '',
        'groupIcon'  => '',
        'text'       => '',
        'stringCont' => 'dialogBody',
        'url'        => '',
        'options'    => [],
        'colLabel'   => '',
        'target'     => '',
        'custom'     => false,
    ])
    {
        $param = $this->setDefaultDialogEntry($param);

        $html = view("datatable::component.{$param['component']}" ,[
            'id'                => preg_replace('/[\._]/','-' ,$param['id']),
            'data'              => $param['id'],
            'name'              => $param['name'],
            'title'             => $param['title'],
            'type'              => $param['type'],
            'value'             => $param['value'],
            'class'             => $param['class'],
            'attr'              => $param['attr'],
            'placeholder'       => shortIfElse($this->params['placeholder'] ,$this->params['placeholder'] ,$param['title']),

            //for autocomplete and select
            'colLabel'          => $param['colLabel'],
            'options'           => $param['options'],
            // for autocomplete
            'url'               => $param['url'],
            'target'            => $param['target'],
            // for input group
            'groupClass'        => $param['groupClass'],
            'groupIcon'         => $param['groupIcon'],
            // for button
            'text'              => $param['text'],
            'stringCont'        => $param['stringCont'] == 'dialogBody',
            // all input
            'star'              => matchClass('req' ,$param['class']),
            // pass
            'refresh'           => matchClass('refresh' ,$param['class']),
            // all input
            'gridSystemResult'  => $this->gridSystemResult,
            // set default Lang for input
            'datatable_lang'    => shortIfElse($this->params['lang'] ,$this->params['lang'] ,$this->locale),
        ])->render();

        return $this->checkReturnValue($html ,$param['custom'] ,$param['stringCont']);
    }

    /**
     * @param $id
     * @param $name
     * @param $value
     * @param $type
     * @param $class
     * @param $attr
     * @param bool $custom
     * @return mixed
     */
    protected function _HiddenInput($id, $name, $value, $type , $class , $attr , $custom = false)
    {
        return $this->_dialogEntry([
            'component' => 'input_hidden',
            'id'        => $id,
            'name'      => $name,
            'type'      => $type,
            'value'     => $value,
            'class'     => $class,
            'attr'      => $attr,
            'custom'    => $custom,
        ]);
    }

    /**
     * @param $title
     * @param $id
     * @param $name
     * @param $value
     * @param $type
     * @param $class
     * @param $attr
     * @param bool $custom
     * @return mixed
     */
    protected function _Input($title, $id, $name, $value, $type, $class, $attr , $custom = false)
    {
        return $this->_dialogEntry([
            'component'         => 'input',
            'title'             => $title,
            'id'                => $id,
            'name'              => $name,
            'type'              => $type,
            'value'             => $value,
            'class'             => $class,
            'attr'              => $attr,
            'custom'            => $custom,
        ]);
    }

    /**
     * @param $title
     * @param $id
     * @param $name
     * @param $type
     * @param $class
     * @param $attr
     * @param bool $custom
     * @return mixed
     */
    protected function _InputPassword($title, $id, $name, $type , $class, $attr , $custom = false)
    {
        return $this->_dialogEntry([
            'component'         => 'input_password',
            'title'             => $title,
            'id'                => $id,
            'name'              => $name,
            'type'              => $type,
            'class'             => $class,
            'attr'              => $attr,
            'custom'            => $custom,
        ]);
    }

    /**
     * @param $title
     * @param $id
     * @param $name
     * @param $type
     * @param $class
     * @param $groupIcon
     * @param $groupClass
     * @param $attr
     * @param bool $custom
     * @return mixed
     */
    protected function _InputGroup($title ,$id ,$name ,$value ,$type ,$class ,$groupIcon ,$groupClass ,$attr ,$custom = false)
    {
        return $this->_dialogEntry([
            'component'         => 'input_group',
            'title'             => $title,
            'id'                => $id,
            'name'              => $name,
            'value'             => $value,
            'type'              => $type,
            'class'             => $class,
            'attr'              => $attr,
            'groupClass'        => $groupClass,
            'groupIcon'         => $groupIcon,
            'custom'            => $custom,
        ]);
    }

    /**
     * @param $title
     * @param $id
     * @param $name
     * @param $class
     * @param $attr
     * @param bool $custom
     * @return mixed
     */
    protected function _TextArea($title ,$id ,$name ,$value ,$class ,$attr ,$custom = false)
    {
        return $this->_dialogEntry([
            'component'         => 'textArea',
            'title'             => $title,
            'id'                => $id,
            'name'              => $name,
            'value'             => $value,
            'class'             => $class,
            'attr'              => $attr,
            'custom'            => $custom,
        ]);
    }

    /**
     * @param $title
     * @param $id
     * @param $name
     * @param $type
     * @param $class
     * @param $attr
     * @param bool $custom
     * @return mixed
     */
    protected function _InputNumber($title ,$id ,$name ,$value ,$type ,$class ,$attr ,$custom = false)
    {
        return $this->_dialogEntry([
            'component'         => 'input_number',
            'title'             => $title,
            'id'                => $id,
            'name'              => $name,
            'value'             => $value,
            'class'             => $class,
            'attr'              => $attr,
            'type'              => $type,
            'custom'            => $custom,
        ]);
    }

    /**
     * @param $text
     * @param $id
     * @param $type
     * @param $class
     * @param $attr
     * @param bool $custom
     * @param string $stringCont
     * @return mixed
     */
    protected function _Button($text, $id, $type, $class, $attr, $custom = false, $stringCont = 'body')
    {
        return $this->_dialogEntry([
            'component'  => 'button',
            'id'         => $id,
            'class'      => $class,
            'attr'       => $attr,
            'type'       => $type,
            'text'       => $text,
            'stringCont' => 'dialog' . ucfirst($stringCont),
            'custom'     => $custom,
        ]);
    }

    /**
     * @param $url
     * @param $title
     * @param $id
     * @param $name
     * @param string $colLabel
     * @param string $class
     * @param string $attr
     * @param string $target
     * @param bool $custom
     * @return mixed
     */
    protected function _Autocomplete($url, $title, $id, $name, $value, $colLabel = '', $class = '', $attr = '', $target = '', $custom = false)
    {
        if(!empty($value))
            foreach ($value as $item)
                $value['selected'] = true;

        return $this->_dialogEntry([
            'component'         => 'autocomplete',
            'title'             => $title,
            'id'                => $id,
            'name'              => $name,
            'value'             => empty($value) ? $value : [$value],
            'class'             => $class,
            'attr'              => $attr,
            'url'               => $url,
            'colLabel'          => $colLabel,
            'target'            => $target,
            'custom'            => $custom,
        ]);
    }

    /**
     * @param $obj
     * @param $title
     * @param $id
     * @param $name
     * @param $colLabel
     * @param $class
     * @param $attr
     * @param bool $custom
     * @return mixed
     */
    protected function _Select($obj, $title, $id, $name, $colLabel, $class, $attr, $custom = false)
    {
        return $this->_dialogEntry([
            'component'         => 'select',
            'title'             => $title,
            'id'                => $id,
            'name'              => $name,
            'class'             => $class,
            'attr'              => $attr,
            'options'           => $obj,
            'colLabel'          => $colLabel,
            'custom'            => $custom,
        ]);
    }

    /**
     * @param $id
     * @param $html
     * @param $class
     * @param $attr
     * @param bool $custom
     * @return mixed
     */
    protected function _addCont($id , $html , $class , $attr , $custom = false)
    {
        $html = "<div id='$id' class='$class' $attr>$html</div>";

        return $this->checkReturnValue($html ,$custom);
    }

    /**
     * @param $id
     * @param $class
     * @param $attr
     * @param bool $custom
     * @return mixed
     */
    protected function _startCont($id , $class , $attr , $custom = false)
    {
        $id   = !empty($id) ? $id : '';
        $attr = !empty($attr) ? $attr : '';

        $html = "<div id='$id' class='$class' $attr>";

        return $this->checkReturnValue($html ,$custom);
    }

    /**
     * @param bool $custom
     * @return mixed
     */
    protected function _endCont($custom = false)
    {
        $html = '</div>';

        return $this->checkReturnValue($html ,$custom);
    }

    /**
     * @param $id
     * @param $title
     * @param $class
     * @param $attr
     * @param bool $custom
     * @return mixed
     */
    protected function _startFieldSet($id , $title , $class , $attr , $custom = false)
    {
        $id   = !empty($id) ? $id : '';
        $attr = !empty($attr) ? $attr : '';

        $html = "<fieldset id='$id' class='$class' $attr>";

        if($title)
            $html .= "<legend>$title</legend>";

        return $this->checkReturnValue($html ,$custom);
    }

    /**
     * @param bool $custom
     * @return mixed
     */
    protected function _endFieldSet($custom = false)
    {
        $html = '</fieldset>';

        return $this->checkReturnValue($html ,$custom);
    }

    /**
     * @param $component
     * @param bool $custom
     * @return mixed
     */
    protected function _addComponent($component , $custom = false)
    {
        $html = $component;

        return $this->checkReturnValue($html ,$custom);
    }
}