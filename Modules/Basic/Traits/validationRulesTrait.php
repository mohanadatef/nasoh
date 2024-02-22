<?php

namespace Modules\Basic\Traits;

use Illuminate\Validation\Rule;
use function language;
use function languageLocale;

trait validationRulesTrait
{
    public function translationValidationRules($class, $rules, $keys, $id = null)
    {
        foreach (language() as $lang) {
            foreach ($keys as $key) {
                $rule = Rule::unique('translations', 'value')
                    ->where('category_type', $class)
                    ->where('key', $key)
                    ->where('language_id', $lang->id);
                if ($id) {
                    $rule = $rule->ignore($id, 'category_id');
                }
                $rules[$key . '.' . $lang->code] = $rule;
                $rules[$key . '.' . $lang->code] .= "|string";
                if(languageLocale() == $lang->code)
                {
                    $rules[$key . '.' .languageLocale()] .= '|required';
                }
            }
        }
        return $rules;
    }

    public function convertPersian($string)
    {
        return strtr($string, array('+'=>'00',' '=>'','۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
    }

    public function convertPersianAr($string)
    {
        return strtr($string, array('+'=>'00',' '=>'','0'=>'۰', '1'=>'۱' ,'2'=> '۲' ,  '3'=>'۳' ,  '4'=>'٤','5'=> '٥' ,'6'=> '٦' , '7'=> '۷' ,'8'=> '۸' ,'9'=> '۹'  ));
    }
}
