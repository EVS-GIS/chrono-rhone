<?php 
namespace App\Http\Controllers\V1\Admin;

use Illuminate\Routing\Controller;
use App\Http\Repositories\V1\Admin\RoleRepository;
use App\Http\Resources\V1\Admin\RoleResource;
use Illuminate\Http\Request;
use App\Http\Requests\V1\Admin\Role\CreateRequest;
use App\Http\Requests\V1\Admin\Role\UpdateRequest;

class RoleController extends Controller
{
    protected $roles;

    public function __construct(RoleRepository $roles)
    {
      $this->roles = $roles;
    }
    public function index()
    {
      /**
      * Get informations for all roles
      * @OA\Get(
      *   path="/roles",
      *   tags={"Roles"},
      *   @OA\Response(response="200", description="Return all roles"),
      *   @OA\Response(response="401", description="You are not allowed to access this endpoint"),
      *   security={
      *     {"jwt": {}}
      *   }
      * )
      */
      return RoleResource::collection($this->roles->index());
    }

    public function show($id)
    {
      /**
      * Get informations for one role
      *
      * @OA\Get(
      *     path="/admin/roles/{id}",
      *     tags={"Roles"},
      *     @OA\Parameter(
      *       name="id",
      *       description="Role id",
      *       required=true,
      *       in="path",
      *       @OA\Schema(type="integer")
      *     ),
      *     @OA\Response(response="200", description="Return role informations"),
      *     @OA\Response(response="401", description="You are not allowed to access this endpoint"),
      *     security={
      *       {"jwt": {}}
      *     }
      * )
      */
      return new RoleResource($this->roles->find($id));
    }

    public function store(CreateRequest $request)
    {
      /**
      * Add new role
      * @OA\Post(
      *   path="/admin/roles",
      *   tags={"Roles"},
      *   @OA\RequestBody(
      *     required=true,
      *      @OA\MediaType(
      *        mediaType="application/json",
      *        @OA\Schema(
      *         required={"slug", "name"},    
      *         @OA\Property(
      *           property="slug",
      *           type="string",
      *           example="visitor",
      *           description="Role slug"
      *         ),
      *         @OA\Property(
      *           property="name",
      *           type="string",
      *           example="Visitor",
      *           description="Role name"
      *         )
      *       )
      *     )
      *   ),
      *   @OA\Response(response="200", description="Success"),
      *   @OA\Response(response="401", description="You are not allowed to create a role"),
      *   security={
      *     {"jwt": {}}
      *   }
      * )
      */
      $this->roles->store($request->all());
      return response()->json(['status'=>'success','message'=>'Role created']);
    }

    public function update(UpdateRequest $request, $id)
    {
      /**
      * Update a role
      * @OA\Put(
      *   path="/admin/roles/{id}",
      *   tags={"Roles"},
      *   @OA\Parameter(
      *     name="id",
      *     description="Role id",
      *     required=true,
      *     in="path",
      *     @OA\Schema(type="integer")
      *   ),
      *   @OA\RequestBody(
      *     required=true,
      *      @OA\MediaType(
      *        mediaType="application/json",
      *        @OA\Schema(
      *         required={"slug", "name"},    
      *         @OA\Property(
      *           property="slug",
      *           type="string",
      *           example="visitor",
      *           description="Role slug"
      *         ),
      *         @OA\Property(
      *           property="name",
      *           type="string",
      *           example="Visitor",
      *           description="Role name"
      *         )
      *       )
      *     )
      *   ),
      *   @OA\Response(response="200", description="Success"),
      *   @OA\Response(response="401", description="You are not allowed to update a role"),
      *   security={
      *     {"jwt": {}}
      *   }
      * )
      */
      $this->roles->update($request->all(), $id);
      return response()->json(['status'=>'success','message'=>'Role modified']);
    }

    public function destroy($id)
    {
      /**
      * Delete a role
      * @OA\Delete(
      *   path="/admin/roles/{id}",
      *   tags={"Roles"},
      *   @OA\Parameter(
      *     name="id",
      *     description="Role id",
      *     required=true,
      *     in="path",
      *     @OA\Schema(type="integer")
      *   ),
      *   @OA\Response(response="200", description="Success"),
      *   @OA\Response(response="401", description="You are not allowed to delete this role"),
      *   security={
      *     {"jwt": {}}
      *   }
      * )
      */
      $this->roles->destroy($id);
      return response()->json(['status'=>'success','message'=>'Role deleted']);
    }
}
