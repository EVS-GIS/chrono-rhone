<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsContributor
{
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        if ($user && ($user->role->slug == "admin" || $user->role->slug == "editor" || $user->role->slug == "contributor"))
        {
            return $next($request);
        }
        return response()->json(['status'=>'error','message'=>'Endpoint not allowed'],401);
    }
}