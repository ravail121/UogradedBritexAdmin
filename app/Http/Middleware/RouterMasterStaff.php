<?php

namespace App\Http\Middleware;

use Closure;

class RouterMasterStaff
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
        if(auth()->user()->company_id == 0){
             return redirect('/master-admin')->with('status', "Please Login with a company to View this Page");
        }
        return $next($request);
    }
}
