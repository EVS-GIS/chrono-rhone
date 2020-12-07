<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\V1\Admin\UserResource;
use Illuminate\Http\Request;
use Response;

class AuthController extends Controller
{
    
    public function login()
    {
    /**
    * Get a Json Web Token for User
    * @OA\Post(
    *     path="/auth/login",
    *     tags={"Authentication"},
    *     @OA\Parameter(
    *       name="email",
    *       description="User mail address",
    *       required=true,
    *       in="query",
    *       @OA\Schema(type="string")
    *     ),
    *     @OA\Parameter(
    *       name="password",
    *       description="User password",
    *       required=true,
    *       in="query",
    *       @OA\Schema(type="string")
    *     ),
    *     @OA\Response(response="200", description="Get a JWT token"),
    *     @OA\Response(response="401", description="Invalid credentials")
    * )
    */
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'message' => 'you are not allowed to access this application'
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
    /**
    * Log the user out (Invalidate the token)
    *
    * @OA\Post(
    *     path="/auth/logout",
    *     tags={"Authentication"},
    *     @OA\Response(response="200", description="Logged out"),
    * )
    */
        $this->guard()->logout();

        return response()->json([
            'status' => 'success',
            'message' =>'Successfully logged out'
        ]);
    }

    public function refresh()
    {
    /**
     * Refresh a token.
    * @OA\Post(
    *     path="/auth/refresh",
    *     tags={"Authentication"},
    *     @OA\Response(response="200", description="Get a new JWT for the current user"),
    *     @OA\Response(response="401", description="You are not allowed to renew a token"),
    *     security={
    *       {"jwt": {}}
    *     }
    * )
    */
        return $this->respondWithToken($this->guard()->refresh());
    }
    
    public function me()
    {
    /**
    * Get the authenticated User
    *
    * @OA\Get(
    *     path="/auth/me",
    *     tags={"Authentication"},
    *     @OA\Response(response="200", description="Get my user informations"),
    *     @OA\Response(response="401", description="You are not allowed to access this service"),
    *     security={
    *       {"jwt": {}}
    *     }
    * )
    */  
        return new UserResource($this->guard()->user());
    }

    public function guard()
    {
    /**
     * Get the guard to be used during authentication.
     *
    */
        return Auth::guard();
    }
}
