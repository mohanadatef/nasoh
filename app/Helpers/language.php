<?php

use Illuminate\Support\Facades\App;
use Modules\CoreData\Service\LanguageService;
use Illuminate\Http\Request;

/**
 * @Target this file to make function to help about language for all system
 * @note can call it in all system
 */
/**
 * @throws Exception
 * @note cache this query 60*60*60
 * @result get all language in database
 */
function languageAll()
{
    return app()->make(LanguageService::class)->findBy(request:new Request());
}

/**
 * @result get locale from app file
 */
function languageLocale()
{
    return App::getLocale();
}

/**
 * @result get all language sort by order column in table
 * @throws Exception
 */
function language()
{
    return languageAll()->sortBy('order');
}

/**
 * @throws Exception
 * @result get all language status active only sort by order column in table
 */
function languageActive()
{
    return languageAll()->where('status', activeType()['as'])->sortBy('order');
}

/**
 * @param $id => id language we want change it
 * @throws Exception
 * @result make app locale change
 */
function changeLocaleLanguage($id)
{
    App::setLocale(checkLocaleLanguage($id));
}

/**
 * @param $id => language id we want get code it
 * @throws Exception
 * @result get code language by id if not found id return locale code language
 */
function checkLocaleLanguage($id)
{
    return languageAll()->find($id)->code ?? languageLocale();
}

/**
 * @result get id language by code
 * @throws Exception
 */
function languageId()
{
    return languageAll()->where('code',languageLocale())->first()->id ?? "";
}
