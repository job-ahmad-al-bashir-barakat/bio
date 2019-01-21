<?php

namespace Aut\DataTable\Http\Maker;

use Aut\DataTable\Exceptions\UndefinedMethodCallException;

class BaseDataTableMaker
{

    public function callTable($factory ,$method ,$model = null ,$request = null)
    {
        if(!method_exists($factory ,$method)) {
            throw new UndefinedMethodCallException("method $method not registered");
        }

        return $factory->$method($model, $request);
    }

    public function callOperation($factory ,$method ,$model = null ,$request = null ,$result = null)
    {
        return $factory->$method($model ,$request ,$result);
    }

    public function validate($factory ,$method)
    {
        return $factory->$method();
    }
}