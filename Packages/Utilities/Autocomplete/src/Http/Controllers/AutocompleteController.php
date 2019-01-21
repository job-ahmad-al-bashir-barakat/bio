<?php

namespace Aut\Autocomplete\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;
use Modules\Control\Entities\TagList;
use Route;
use Auth;

class AutocompleteController
{
    protected $autocomplete;

    protected $model;

    protected $with;

    protected $data;

    protected $langs;

    protected $isLang;

    protected $q;

    protected $conditions;

    protected $colId;

    protected $colName;

    protected $colText;

    protected $colTitle;

    protected $tags;

    public function __construct()
    {
        $this->initModel();
    }

    function autocomplete(Request $request, $model)
    {
        $model = $this->model;

        $object = new $model();

        if($this->q)
        {
            if(is_callable($this->q))
            {
                $object = call_user_func($this->q ,$request ,$object);
            }
            else
            {
                foreach ($this->q as $whereHasOrIndex => $col)
                {
                    $q = str_replace(' ', '%', request()->input('q', ''));

                    if(!is_numeric($whereHasOrIndex))
                    {
                        $object = $object->whereHas($whereHasOrIndex ,function ($query) use ($col ,$q) {

                            if(!$this->isLang && Str::contains($col ,'{langs}'))
                            {
                                foreach ($this->langs as $lang)
                                    $query->where("{$col}_{$lang}", 'like', '%' . $q . '%');
                            }
                            else
                                $query->where($col, 'like', '%' . $q . '%');
                        });
                    }
                    else
                    {
                        if(!$this->isLang && Str::contains($col ,'{langs}'))
                        {
                            foreach ($this->langs as $lang)
                            {
                                $col_lang = str_replace('{langs}', $lang, $col);

                                $object = $object->where($col_lang, 'like', '%' . $q . '%');
                            }
                        }
                        else
                            $object = $object->where($col, 'like', '%' . $q . '%');
                    }
                }
            }
        }

        if(!empty($this->conditions))
        {
            if(is_callable($this->conditions))
            {
                $object = call_user_func($this->conditions ,$request ,$object);
            }
            else
            {
                foreach ($this->conditions as $whereHasOrIndex => $condition) {

                    $pattern = '/.+:/';
                    // get real value
                    $value = preg_replace($pattern ,'',$condition[2]);
                    // get value type
                    preg_match($pattern ,$condition[2] ,$type);

                    if(!empty($type)) {

                        $type = substr($type[0], 0, -1);
                        switch ($type) {
                            case 'request' : $value = \request()->input($value ,'');
                        }
                    }

                    // condition
                    if(!is_numeric($whereHasOrIndex)) {

                        if($value)
                            $object = $object->whereHas($whereHasOrIndex ,function ($query) use ($condition ,$value) {

                                $query->where($condition[0] ,$condition[1] ,$value);
                            });

                    } else {

                        if($value)
                            $object = $object->where($condition[0] ,$condition[1] ,$value);
                    }
                }
            }
        }

        $helper = function ($request ,$object ,$prefix = 'Autocomplete') {

            $autocompleteHelperClass = config('autocomplete.AutocompleteHelperClass');

            if($autocompleteHelperClass)
            {
                $method = camel_case("{$this->autocomplete}$prefix");

                $factory = new $autocompleteHelperClass();

                if(method_exists($factory ,$method))
                    $object = $factory->$method($request ,$object);
            }

            return $object;
        };

        $object = $helper($request ,$object);

        if($this->tags)
        {
            $object = $object->where(function ($query){
                return $query->where('approvied','=',true)
                    ->orWhere('user_id','=',\Auth::id());
            })->orderBy('approvied','asc');
        }

        if(!empty($this->with))
            $object->with($this->with);

        $data = $object->get();

        if($object->count() && $this->data)
            $data = $object->first()->{$this->data};

        $helperFunc = function ($item ,$col) {

            foreach (explode('->', $col) as $col)
                $item = isset($item->$col) ? $item->$col : $item->first()[$col];

            return $item;
        };

        $replaceCol = function ($colNameOrText) {

            return str_replace('{lang}' ,\App::getLocale() ,$colNameOrText);
        };

        $result = [];
        $data->each(function ($item ,$index) use (&$result ,$helperFunc ,$replaceCol) {

            // get id
            $id = $item;
            foreach (explode('->', $this->colId) as $col)
                $id = isset($id->$col) ? $id->$col : $id->first()[$col];

            $finalResult = function ($item ,$col_target)  use ($helperFunc, $replaceCol){

                if(is_array($col_target))
                {
                    $result = [];
                    foreach ($col_target as $col)
                        $result[] = $helperFunc($item ,$replaceCol($col));

                    $result = implode(' ,' ,$result);
                }
                else
                    $result = $helperFunc($item ,$replaceCol($col_target));

                return $result;
            };

            // get name
            $nameResult  = $finalResult($item,$this->colName);
            $textResult  = $finalResult($item,$this->colText);
            $titleResult = $finalResult($item,$this->colTitle);

            $result[$index]['id']    = $id;
            $result[$index]['name']  = $this->tags ? $this->tagsMenu($item ,$id ,$nameResult) : $nameResult;
            $result[$index]['text']  = $this->tags ? $this->tagsItem($item ,$id ,$textResult) : $textResult;
            $result[$index]['title'] = $titleResult;
            $result[$index]['tags']  = $this->tags;
        });

        return array('items' => $result);
    }

    function tagsMenu ($item ,$id ,$name) {

        $approviedIcon = $item->approvied ? 'text-success' : 'text-danger';

        return view('autocomplete::component.tags_menu',[
            'model'         => $this->autocomplete,
            'approvied'     => $item->approvied,
            'approviedIcon' => $approviedIcon,
            'id'            => $id,
            'name'          => $name,
        ])->render();
    }

    function tagsItem ($item ,$id ,$text) {

        $approviedIcon = $item->approvied ? 'text-success' : 'text-danger';

        return view('autocomplete::component.tags_item',[
            'model'         => $this->autocomplete,
            'approvied'     => $item->approvied,
            'approviedIcon' => $approviedIcon,
            'id'            => $id,
            'text'          => $text,
        ])->render();
    }

    function store(Request $request, $model)
    {
        if($this->tags == false)
            return;

        $text = preg_replace('/ +/',' ',$request->input('text'));

        $model = $this->model;

        // check exists and send response to remove it
        $exists = $model::where($this->colText,'=',$text)
            ->where('approvied','=',true)
            ->get();

        if($exists->count())
            return response()->json(['message' =>  trans('autocomplete::autocomplete.dublicate_entry')],422);

        // create item
        $tag = $model::create(["{$this->colText}" => $text ,'user_id' => Auth::id()]);

        return response()->json([
            "id"   => $tag[$this->colId],
            "text" => $this->tagsItem($tag ,$tag[$this->colId] ,$tag[$this->colText]),
            'name' => $tag[$this->colName],
            'title' => $tag[$this->colTitle]
        ]);
    }

    function destroy($model ,$id)
    {
        if($this->tags == false)
            return;

        $model = $this->model;

        $model::destroy($id);

        return response()->json(['success' => true ,'message' => trans('autocomplete::autocomplete.delete_tage_success')]);
    }

    function approvied(Request $request,$model ,$id)
    {
        if($this->tags == false)
            return;

        $text = preg_replace('/ +/',' ',$request->input('text'));
        $text = preg_replace('/×/','',$text);

        $model = $this->model;

        // check item if is approvied before by onther user
        $exists = $model::where($this->colText,'=',$text)
            ->where($this->colId ,'<>' ,$id)
            ->where('approvied' ,'=' ,true)->get();

        if($exists && $exists->count())
            return response()->json(['message' =>  trans('autocomplete::autocomplete.approvied_before')],422);

        // update approvied
        $obj = $model::where($this->colId,'=',$id);

        $obj->update(['approvied' => true]);

        $tag = $obj->first();

        return response()->json([
            "success" => true,
            "message" => trans('autocomplete::autocomplete.approvied_successfuly'),
            "id"      => $tag[$this->colId],
            "text"    => $this->tagsItem($tag ,$tag[$this->colId] ,$tag[$this->colText]),
            "name"    => $tag[$this->colName],
            "title"   => $tag[$this->colTitle]
        ]);
    }

    private function initModel()
    {
        if(Route::getCurrentRoute() !== null)
        {
            $this->autocomplete = Route::getCurrentRoute()->parameter('model');

            $autocompleteSet = config('autocompleteModels.' . $this->autocomplete);

            if (!$autocompleteSet) {
                throw new Exception('This model not registered');
            }

            $this->isLang    = config('autocomplete.isLangs');
            $this->langs     = \LaravelLocalization::getSupportedLanguagesKeys();
            $withOrNot       = $this->isLang                        ? 'withLang'                     : 'withoutLang';
            $this->model     = isset($autocompleteSet['model'])     ? $autocompleteSet['model']      : '';
            $this->data      = isset($autocompleteSet['data'])      ? $autocompleteSet['data']       : false;
            $this->with      = isset($autocompleteSet['with'])      ? $autocompleteSet['with']       : [];
            $this->q         = isset($autocompleteSet['q'])         ? $autocompleteSet['q']          : config("autocomplete.default.$withOrNot.q");
            $this->conditions= isset($autocompleteSet['conditions'])? $autocompleteSet['conditions'] : [];
            $this->colId     = isset($autocompleteSet['colId'])     ? $autocompleteSet['colId']      : config("autocomplete.default.$withOrNot.colId");
            $this->colName   = isset($autocompleteSet['colName'])   ? $autocompleteSet['colName']    : config("autocomplete.default.$withOrNot.colName");
            $this->colText   = isset($autocompleteSet['colText'])   ? $autocompleteSet['colText']    : config("autocomplete.default.$withOrNot.colText");
            $this->colTitle  = isset($autocompleteSet['colTitle'])  ? $autocompleteSet['colTitle']   : config("autocomplete.default.$withOrNot.colTitle");
            $this->tags           = isset($autocompleteSet['tags'])           ? $autocompleteSet['tags']          : false;
        }
    }
}