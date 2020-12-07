<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;

class IsEditor
{
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        $event = Event::find($request->id);
        if ($user && ($user->role->slug == "admin" || $user->role->slug == "editor"))
        {
            return $next($request);
        } else if($user->id == $event->user_id){
          return $next($request);
        }
        return response()->json(['status'=>'error','message'=>'Endpoint not allowed'],401);
    }
}