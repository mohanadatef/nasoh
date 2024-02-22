<?php

namespace Modules\CoreData\Http\Requests\Country\Dashboard;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\Basic\Traits\ApiResponseTrait;
use Modules\Basic\Traits\validationRulesTrait;
use Modules\CoreData\Entities\Country;

class EditRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules= Country::getValidationRules();
        $rules['code'] = $rules['code'].',code,'.$this->id.',id';
        return $this->translationValidationRules(Country::Class,$rules,Country::translationKey(),$this->id);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiValidation($validator->errors()));
    }
}
