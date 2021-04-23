<?php

namespace App\Http\Middleware;
use Closure;
use App\User;
use Illuminate\Support\Facades\Response;

class InputValidator
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
        $validated = $request->validate([
            'mobile_number' => 'required',//regex:961?(3|70|71|76|78|79|81))\d{6}$
            'name' => 'required|max:50'//|regex:^(?![\s.]+$)[a-zA-Z\s.]*$
        ]);

        if(!$validated){
            return Response::json(
            ['error'=>true,
            "message"=>'Please sure to enter valid data. Valid character for name and valid mobile number started with 961 (without + or 00)'
            ]);
        }

        if(User::where('mobile_number', $request->mobile_number)->first()){
            return Response::json(
                ['error'=>true,
                "message"=>'Someone is using the same phone number'
            ],400);
        }
    
        return $next($request);
    }
}
