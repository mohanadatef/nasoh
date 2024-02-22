<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;


class LangMiddelware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     */
    public function handle($request, Closure $next)
    {
        $lang = languageLocale();
        if ($request->header('lang')) {
            $lang = $request->header('lang');
        } elseif ($request->lang) {
            $lang = $request->lang;
        } elseif ($request->cookie('language') && !$request->expectsJson()) {
            $lang = $request->cookie('language');
        }

        if (user(explode(".",$request->route()->getName())[0])) {
            if (user(explode(".",$request->route()->getName())[0])->lang != $lang) {
                user(explode(".",$request->route()->getName())[0])->update(['lang' => $lang]);
            }
        }
        App::setlocale($lang);
        return $next($request);
    }
}
