<?php

namespace Aut\FileUpload;

use Illuminate\Support\Facades\Facade;

class FileUploadFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     **/

    protected static function getFacadeAccessor()
    {
        return 'FileUpload';
    }
}