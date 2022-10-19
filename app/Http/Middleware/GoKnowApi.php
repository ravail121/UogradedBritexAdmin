<?php

namespace App\Http\Middleware;

use Closure;

class GoKnowApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user()->company->goknows_api_key){
            return $next($request);
        }
        return redirect('/action-queue')->with('status', "Go Know Api Key not Found");

    }
}
