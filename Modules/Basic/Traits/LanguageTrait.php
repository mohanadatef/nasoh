<?php

namespace Modules\Basic\Traits;


use Illuminate\Http\Request;
use function language;

trait LanguageTrait
{
    public function updateOrCreateLanguage($data,Request $request, $key)
    {
        foreach (language() as $lang) {
            foreach ($key as $value) {
                $translation = $data->translation->where('language_id', $lang->id)->where('key', $value)->first();
                if ($translation) {
                    $translation->update(['value' => $request->$value[$lang->code] ?? " "]);
                } elseif(!$translation && isset($request->$value[$lang->code]) && !empty($request->{$value}{$lang->code})) {
                    $data->translation()->create(['key' => $value, 'value' => $request->$value[$lang->code], 'language_id' => $lang->id]);
                }
            }
        }
    }
}
