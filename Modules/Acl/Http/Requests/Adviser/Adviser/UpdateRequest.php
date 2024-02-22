<?php

namespace Modules\Acl\Http\Requests\Adviser\Adviser;
use Illuminate\Contracts\Validation\Validator ;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\Acl\Entities\Adviser;
use Modules\Basic\Traits\ApiResponseTrait;
use Modules\Basic\Traits\validationRulesTrait;

class UpdateRequest extends FormRequest
{
    use ApiResponseTrait,validationRulesTrait;
    public function __construct()
    {
        parent::__construct();
        $this->bank_account_v = true;
    }

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
        if(isset($this->bank_account) && !empty($this->bank_account))
        {
            if(substr($this->bank_account, 0, 2) === "SA" && strlen($this->bank_account) == 24)
            {
                $this->bank_account_v = true;
            }else{
                $this->bank_account_v = false;
            }
        }
        if (isset($this->category)) {
            if (is_array($this->category)) {
                $this->merge(['category' => $this->category]);
            } elseif (strpos($this->category, ',') !== false) {
                $this->merge(['category' => explode(',', $this->category)]);
            } else {

                $this->merge(['category' => [$this->category]]);
            }
        }
        if (isset($this->document)) {
            if (is_array($this->document)) {
                $this->merge(['document' => $this->document]);
            } elseif (strpos($this->document, ',') !== false) {
                $this->merge(['document' => explode(',', $this->document)]);
            } else {

                $this->merge(['document' => [$this->document]]);
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules= Adviser::getValidationRulesUpdate();
        unset($rules['mobile']);
        $rules['email'] = $rules['email'].',email,'.user('adviser')->id.',id';
        $rules['user_name'] = $rules['user_name'].',user_name,'.user('adviser')->id.',id';
        if(!$this->bank_account_v)
        {
            $rules['bank_account'] = 'required';
        }
        return $rules;

    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiValidation($validator->errors()));
    }
    public function messages()
    {
        $messages = ['bank_account.required' => trans('wrong_bank')];
        return $messages;
    }

}
