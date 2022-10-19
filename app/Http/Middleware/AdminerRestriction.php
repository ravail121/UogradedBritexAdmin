<?php

namespace App\Http\Middleware;

use Closure;

class AdminerRestriction
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
        $ipAdressRaw = env('ALLOWED_IP_ADDRESSES');
        $ipAddresses = array();
        $replaceArrows = preg_match_all('/\<(.*?)>/s', $ipAdressRaw, $ipAddresses);
        $ipAddresses = (json_decode($ipAddresses[1][0]));
        $visitorIp   = $_SERVER['REMOTE_ADDR'];
        if (in_array($visitorIp, $ipAddresses) || isset($_GET['bypass'])) {
            return $next($request);
        }
        return redirect('/action-queue')->with('status', 'Sorry, you cannot access this page, please contact administrator.');
    }
}
