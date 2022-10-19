<?php

namespace App\Http\Middleware;

use Closure;

class checkBusinessVerificatonRequired
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
        if(auth()->user()->company->business_verification == 0){
            return redirect('/action-queue')->with('status', "You don't have permission to view this Page");
        }
        return $next($request);
    }
}
