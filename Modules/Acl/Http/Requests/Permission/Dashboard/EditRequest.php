<?php

namespace Modules\Acl\Http\Requests\Permission\Dashboard;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\Acl\Entities\Permission;
use Modules\Basic\Traits\ApiResponseTrait;

class EditRequest extends FormRequest
{
    use ApiResponseTrait;
    /**
     * Determine if the User is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules= Permission::getValidationRulesLogin();
        $rules['name'] = $rules['name'].',name,'.$this->id.',id';
        $rules['label'] = $rules['label'].',label,'.$this->id.',id';
        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiValidation($validator->errors()));
    }
}
