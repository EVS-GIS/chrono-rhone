<?php 
namespace App\Http\Controllers\V1\Admin;

use Illuminate\Routing\Controller;
use App\Http\Repositories\V1\Admin\UserRepository;
use App\Http\Resources\V1\Admin\UserResource;
use Illuminate\Http\Request;
use App\Http\Requests\V1\Admin\User\CreateRequest;
use App\Http\Requests\V1\Admin\User\UpdateRequest;

class UserController extends Controller
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function index()
    {
      /**
      * Get informations for all users
      * @OA\Get(
      *   path="/users",
      *   tags={"Users"},
      *   @OA\Response(response="200", description="Return all users"),
      *   @OA\Response(response="401", description="You are not allowed to access this endpoint"),
      *   security={
      *     {"jwt": {}}
      *   }
      * )
      */
      return UserResource::collection($this->users->index());
    }

    public function show($id)
    {
    /**
    * Get informations for one user
    *
    * @OA\Get(
    *     path="/admin/users/{id}",
    *     tags={"Users"},
    *     @OA\Parameter(
    *       name="id",
    *       description="User id",
    *       required=true,
    *       in="path",
    *       @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(response="200", description="Return user informations"),
    *     @OA\Response(response="401", description="You are not allowed to access this endpoint"),
    *     security={
    *       {"jwt": {}}
    *     }
    * )
    */
      return new UserResource($this->users->find($id));
    }

    public function store(CreateRequest $request)
    {
      /**
      * Add new user
      * @OA\Post(
      *   path="/admin/users",
      *   tags={"Users"},
      *   @OA\RequestBody(
      *     required=true,
      *      @OA\MediaType(
      *        mediaType="application/json",
      *        @OA\Schema(
      *         required={"firstname", "name","organization","email","password","password_confirmation","role"},    
      *         @OA\Property(
      *           property="firstname",
      *           type="string",
      *           example="John",
      *           description="Firstname"
      *         ),
      *         @OA\Property(
      *           property="name",
      *           type="string",
      *           example="Doe",
      *           description="Name"
      *         ),
      *         @OA\Property(
      *           property="organization",
      *           type="string",
      *           example="ENS de Lyon",
      *           description="Organization"
      *         ),
      *         @OA\Property(
      *           property="email",
      *           type="email",
      *           example="john.doe@ens-lyon.fr",
      *           description="Mail address"
      *         ),
      *         @OA\Property(
      *           property="password",
      *           type="password",
      *           example="YourPassword",
      *           description="Password"
      *         ),
      *         @OA\Property(
      *           property="password_confirmation",
      *           type="password",
      *           example="YourPassword",
      *           description="Password confirmation"
      *         ),
      *         @OA\Property(
      *           property="role",
      *           type="integer",
      *           example=3,
      *           description="Role id for this user"
      *         ),
      *       )
      *     )
      *   ),
      *   @OA\Response(response="200", description="Success"),
      *   @OA\Response(response="401", description="You are not allowed to create a user"),
      *   security={
      *     {"jwt": {}}
      *   }
      * )
      */
      $this->users->store($request->all());
      return response()->json(['status'=>'success','message'=>'User created']);
    }

    public function update(UpdateRequest $request, $id)
    {
      /**
      * Update a user
      * @OA\Put(
      *   path="/admin/users/{id}",
      *   tags={"Users"},
      *   @OA\Parameter(
      *     name="id",
      *     description="User id",
      *     required=true,
      *     in="path",
      *     @OA\Schema(type="integer")
      *   ),
      *   @OA\RequestBody(
      *     required=true,
      *      @OA\MediaType(
      *        mediaType="application/json",
      *        @OA\Schema(
      *         required={"firstname", "name","organization","email"},    
      *         @OA\Property(
      *           property="firstname",
      *           type="string",
      *           example="John",
      *           description="Firstname"
      *         ),
      *         @OA\Property(
      *           property="name",
      *           type="string",
      *           example="Doe",
      *           description="Name"
      *         ),
      *         @OA\Property(
      *           property="organization",
      *           type="string",
      *           example="ENS de Lyon",
      *           description="Organization"
      *         ),
      *         @OA\Property(
      *           property="email",
      *           type="email",
      *           example="john.doe@ens-lyon.fr",
      *           description="Mail address"
      *         ),
      *         @OA\Property(
      *           property="password",
      *           type="password",
      *           example="YourPassword",
      *           description="Password"
      *         ),
      *         @OA\Property(
      *           property="password_confirmation",
      *           type="password",
      *           example="YourPassword",
      *           description="Password confirmation"
      *         ),
      *         @OA\Property(
      *           property="role",
      *           type="integer",
      *           example=3,
      *           description="Role id for this user"
      *         ),
      *       )
      *     )
      *   ),
      *   @OA\Response(response="200", description="Success"),
      *   @OA\Response(response="401", description="You are not allowed to update a user"),
      *   security={
      *     {"jwt": {}}
      *   }
      * )
      */  
      $this->users->update($request->all(), $id);
      return response()->json(['status'=>'success','message'=>'User modified']);
    }

    public function destroy($id)
    {
      /**
      * Delete a user
      * @OA\Delete(
      *   path="/admin/users/{id}",
      *   tags={"Users"},
      *   @OA\Parameter(
      *     name="id",
      *     description="User id",
      *     required=true,
      *     in="path",
      *     @OA\Schema(type="integer")
      *   ),
      *   @OA\Response(response="200", description="Success"),
      *   @OA\Response(response="401", description="You are not allowed to delete this user"),
      *   security={
      *     {"jwt": {}}
      *   }
      * )
      */
      $this->users->destroy($id);
      return response()->json(['status'=>'success','message'=>'User deleted']);
    }
}
