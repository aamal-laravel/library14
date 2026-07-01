<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $lang = $request->user()->customer->lang;
        $lang = $request->getPreferredLanguage(config('app.supported_lang'));
        app()->setlocale($lang);
        return $next($request);
    }
}
