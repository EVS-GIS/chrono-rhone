<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsUser
{
    public function handle($request, Closure $next)
    {
      $user = $request->user();
      if ($user->role->slug == "admin" || $user->id == $request->id)
      {
        return $next($request);
      }
       
      return response()->json(['status'=>'error','message'=>'Endpoint not allowed'],401);
    }
}