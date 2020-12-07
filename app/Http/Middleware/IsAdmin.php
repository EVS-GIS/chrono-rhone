<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        if ($user && $user->role->slug == "admin")
        {
            return $next($request);
        }
        return response()->json(['status'=>'error','message'=>'Endpoint not allowed'],401);
    }
}