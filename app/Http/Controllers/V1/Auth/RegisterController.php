<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Models\User;
use App\Notifications\Newuser;
use Illuminate\Http\JsonResponse;
class RegisterController extends Controller
{
    /**
     * Handle a registration request for the application.
     */
    public function register(RegisterRequest $request)
    {
        $admins = User::where('role_id',1)->get();
        foreach($admins as $admin){
            $admin->notify(new Newuser());
        }

        return User::create([
            'firstname' => $request->firstname,
            'name' => $request->name,
            'organization' => $request->organization,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);      
    }
}