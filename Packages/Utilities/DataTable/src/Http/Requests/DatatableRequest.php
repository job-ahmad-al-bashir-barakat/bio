<?php

namespace Aut\DataTable\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DatatableRequest extends FormRequest
{
    protected $request_target;

    protected $typeOf;

    protected function getValidatorInstance()
    {
        $table = request()->route('model');

        $tableSet = config("datatableModels.$table");

        $requestValidation =  isset($tableSet['request'])
            ? new $tableSet['request']()
            : null;

        $this->request_target = $requestValidation;

        return parent::getValidatorInstance();
    }

    /**
     * Get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function messages()
    {
        return empty($this->request_target)
            ? []
            : $this->request_target->messages();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return empty($this->request_target)
            ? true
            : $this->request_target->authorize();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return empty($this->request_target)
            ? []
            : $this->request_target->rules();
    }
}
