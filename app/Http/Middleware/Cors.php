<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        /*header('Access-Control-Allow-Origin : *');
        header('Access-Control-Allow-Methods : GET, POST, PATCH, PUT, DELETE, OPTIONS, HEAD');
        header('Access-Control-Allow-Headers : Content-type, Accept, X-Requested-With, X-Auth-Token, Authorization, Origin');*/
        $response = $next($request);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS, HEAD');
        $response->headers->set('Access-Control-Allow-Headers', 'Origin, Content-type, Accept, X-Requested-With, X-Auth-Token, Authorization');
        return $response;
    }
}
