<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
/**
  * @OA\Info(
  *   version="1.0",
  *   title="Chrono Rhône API",
  *   description="Description of Chrono Rhône API",
  *   @OA\Contact(
  *     email="arnaud.fanny@ens-lyon.fr"
  *   )
  *)
*/
/**
  * @OA\Server(
  *   url="/api/v1",
  *   description="First version of Chrono Rhône API"
  * )
  * @OA\Tag(
  *   name="Authentication",
  *   description="Operations about authentication with JWT"
  * )
  * @OA\Tag(
  *   name="Events",
  *   description="Operations about events"
  * )
  * @OA\Tag(
  *   name="Images",
  *   description="Operations about images"
  * )
  * @OA\Tag(
  *   name="Users",
  *   description="Operations about users"
  * )
  * @OA\Tag(
  *   name="Roles",
  *   description="Operations about roles"
  * )  
  * @OA\Tag(
  *   name="Thematics",
  *   description="Operations about thematics"
  * )
  * @OA\Tag(
  *   name="Themes",
  *   description="Operations about themes"
  * )
  * @OA\Tag(
  *   name="Relationships",
  *   description="Operations about relationships"
  * ) 
*/  
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }
}
