<?php

namespace App\Http\Middleware;
use Closure;
use App\RequestLogging;

class RequestLoggingMiddleware
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
        RequestLogging::create([
            "method"=>$request->method(),
            "details"=>"URI: ".$request->path(),
            "withToken"=>strlen($request->bearerToken())>0
        ]);
        return $next($request);
    }
}
