<?php

namespace Modules\Acl\Http\Requests\Client\Client;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\Acl\Entities\Client;
use Modules\Basic\Traits\ApiResponseTrait;
use Modules\Basic\Traits\validationRulesTrait;

class UpdateRequest extends FormRequest
{
    use ApiResponseTrait,validationRulesTrait;

    /**
     * Determine if the User is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge(['mobile' => $this->convertPersian($this->mobile)]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules= Client::getValidationRulesUpdate();
        $rules['mobile'] = $rules['mobile'].',mobile,'.user('client')->id.',id';
        $rules['email'] = $rules['email'].',email,'.user('client')->id.',id';
        return $rules;

    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiValidation($validator->errors()));
    }


}
