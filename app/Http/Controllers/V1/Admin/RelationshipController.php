<?php 
namespace App\Http\Controllers\V1\Admin;

use Illuminate\Routing\Controller;
use App\Http\Repositories\V1\Admin\RelationshipRepository;
use App\Http\Resources\V1\Admin\RelationshipResource;
use Illuminate\Http\Request;
use App\Http\Requests\V1\Admin\Relationship\CreateRequest;
use App\Http\Requests\V1\Admin\Relationship\UpdateRequest;

class RelationshipController extends Controller
{
    protected $relationships;

    public function __construct(RelationshipRepository $relationships)
    {
        $this->relationships = $relationships;
    }

    public function index()
    {
      /**
      * Get informations for all relationships
      * @OA\Get(
      *   path="/relationships",
      *   tags={"Relationships"},
      *   @OA\Response(response="200", description="Return all relationships"),
      *   @OA\Response(response="401", description="You are not allowed to access this endpoint")
      * )
      */
      return RelationshipResource::collection($this->relationships->index());
    }

   public function show($id)
    {
      /**
      * Get informations for one relationship
      *
      * @OA\Get(
      *     path="/admin/relationships/{id}",
      *     tags={"Relationships"},
      *     @OA\Parameter(
      *       name="id",
      *       description="Relationship id",
      *       required=true,
      *       in="path",
      *       @OA\Schema(type="integer")
      *     ),
      *     @OA\Response(response="200", description="Return relationship informations"),
      *     @OA\Response(response="401", description="You are not allowed to access this endpoint"),
      *     security={
      *       {"jwt": {}}
      *     }
      * )
      */
      return new RelationshipResource($this->relationships->find($id));
    }

    public function store(CreateRequest $request)
    {
      /**
      * Add new relationship
      * @OA\Post(
      *   path="/admin/relationships",
      *   tags={"Relationships"},
      *   @OA\RequestBody(
      *     required=true,
      *      @OA\MediaType(
      *        mediaType="application/json",
      *        @OA\Schema(
      *         required={"name_fr", "name_en"},    
      *         @OA\Property(
      *           property="name_fr",
      *           type="string",
      *           example="Histoire",
      *           description="French relationship name"
      *         ),
      *         @OA\Property(
      *           property="name_en",
      *           type="string",
      *           example="Story",
      *           description="English relationship name"
      *         )
      *       )
      *     )
      *   ),
      *   @OA\Response(response="200", description="Success"),
      *   @OA\Response(response="401", description="You are not allowed to create a relationship"),
      *   security={
      *     {"jwt": {}}
      *   }
      * )
      */
      $this->relationships->store($request->all());
      return response()->json(['status'=>'success','message'=>'Relationship created']);
    }

    public function update(UpdateRequest $request, $id)
    {
      /**
      * Update a relationship
      * @OA\Put(
      *   path="/admin/relationships/{id}",
      *   tags={"Relationships"},
      *   @OA\Parameter(
      *     name="id",
      *     description="Relationship id",
      *     required=true,
      *     in="path",
      *     @OA\Schema(type="integer")
      *   ),
      *   @OA\RequestBody(
      *     required=true,
      *      @OA\MediaType(
      *        mediaType="application/json",
      *        @OA\Schema(
      *         required={"name_fr", "name_en"},    
      *         @OA\Property(
      *           property="name_fr",
      *           type="string",
      *           example="Histoire",
      *           description="French relationship name"
      *         ),
      *         @OA\Property(
      *           property="name_en",
      *           type="string",
      *           example="Story",
      *           description="English relationship name"
      *         )
      *       )
      *     )
      *   ),
      *   @OA\Response(response="200", description="Success"),
      *   @OA\Response(response="401", description="You are not allowed to update a relationship"),
      *   security={
      *     {"jwt": {}}
      *   }
      * )
      */      
      $this->relationships->update($request->all(), $id);
      return response()->json(['status'=>'success','message'=>'Relationship modified']);
    }

    public function destroy($id)
    {
      /**
      * Delete a relationship
      * @OA\Delete(
      *   path="/admin/relationships/{id}",
      *   tags={"Relationships"},
      *   @OA\Parameter(
      *     name="id",
      *     description="Relationship id",
      *     required=true,
      *     in="path",
      *     @OA\Schema(type="integer")
      *   ),
      *   @OA\Response(response="200", description="Success"),
      *   @OA\Response(response="401", description="You are not allowed to delete this relationship"),
      *   security={
      *     {"jwt": {}}
      *   }
      * )
      */      
      $this->relationships->destroy($id);
      return response()->json(['status'=>'success','message'=>'Relationship deleted']);
    }
}