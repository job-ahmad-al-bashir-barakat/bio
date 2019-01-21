<?php

namespace Aut\FileUpload\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Route;

class UploadFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $route = Route::getCurrentRoute()->parameters();
        $model = $route['model'];

        $imageGeneralConfig = config("fileupload.setting.{$route['type']}");
        $imageLocalConfig   = config("fileupload.{$model}");

        $validate  = isset($imageLocalConfig['validate'])
            ? $imageLocalConfig['validate']
            : $imageGeneralConfig['validate'];

        return [
            $model => $validate
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
