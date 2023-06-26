<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIsAdminAndNotManager
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
        if(Auth::user()->role === 3) {
            return $next($request);
        }
        else if (Auth::user()->role === 2) {
            return response()->json(['msg' => 'У вас нет прав для этого действия'], 403);
        }
        else{
            return response()->json(['status' => 'Unauthorized'],403);
        }
    }
}
