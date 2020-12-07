<?php 
namespace App\Http\Controllers\V1\Admin;

use Illuminate\Routing\Controller;
use App\Http\Repositories\V1\Admin\ThematicRepository;
use App\Http\Resources\V1\Admin\ThematicResource;
use Illuminate\Http\Request;
use App\Http\Requests\V1\Admin\Thematic\CreateRequest;
use App\Http\Requests\V1\Admin\Thematic\UpdateRequest;

class ThematicController extends Controller
{
    protected $thematics;

    public function __construct(ThematicRepository $thematics)
    {
      $this->thematics = $thematics;
    }

    public function index()
    {
      /**
      * Get informations for all thematics
      * @OA\Get(
      *   path="/thematics",
      *   tags={"Thematics"},
      *   @OA\Response(response="200", description="Return all thematics"),
      *   @OA\Response(response="401", description="You are not allowed to access this endpoint")
      * )
      */
      return ThematicResource::collection($this->thematics->index());
    }

    public function show($id)
    {
      /**
      * Get informations for one thematic
      *
      * @OA\Get(
      *     path="/admin/thematics/{id}",
      *     tags={"Thematics"},
      *     @OA\Parameter(
      *       name="id",
      *       description="Thematic id",
      *       required=true,
      *       in="path",
      *       @OA\Schema(type="integer")
      *     ),
      *     @OA\Response(response="200", description="Return thematic informations"),
      *     @OA\Response(response="401", description="You are not allowed to access this endpoint"),
      *     security={
      *       {"jwt": {}}
      *     }
      * )
      */
      return new ThematicResource($this->thematics->find($id));
    }

    public function store(CreateRequest $request)
    {
      /**
      * Add new thematic
      * @OA\Post(
      *   path="/admin/thematics",
      *   tags={"Thematics"},
      *   @OA\RequestBody(
      *     required=true,
      *      @OA\MediaType(
      *        mediaType="application/json",
      *        @OA\Schema(
      *         required={"name_fr", "name_en","ranking"},    
      *         @OA\Property(
      *           property="name_fr",
      *           type="string",
      *           example="Thematic 1",
      *           description="French thematic name"
      *         ),
      *         @OA\Property(
      *           property="name_en",
      *           type="string",
      *           example="Thematic 1",
      *           description="English thematic name"
      *         ),
      *         @OA\Property(
      *           property="ranking",
      *           type="integer",
      *           example=10,
      *           description="Rank for this thematic"
      *         )
      *       )
      *     )
      *   ),
      *   @OA\Response(response="200", description="Success"),
      *   @OA\Response(response="401", description="You are not allowed to create a thematic"),
      *   security={
      *     {"jwt": {}}
      *   }
      * )
      */
      $this->thematics->store($request->all());
      return response()->json(['status'=>'success','message'=>'Thematic created']);
    }

    public function update(UpdateRequest $request, $id)
    {
      /**
      * Update a thematic
      * @OA\Put(
      *   path="/admin/thematics/{id}",
      *   tags={"Thematics"},
      *   @OA\Parameter(
      *     name="id",
      *     description="Thematic id",
      *     required=true,
      *     in="path",
      *     @OA\Schema(type="integer")
      *   ),
      *   @OA\RequestBody(
      *     required=true,
      *      @OA\MediaType(
      *        mediaType="application/json",
      *        @OA\Schema(
      *         required={"name_fr", "name_en","ranking"},    
      *         @OA\Property(
      *           property="name_fr",
      *           type="string",
      *           example="Thematic 1",
      *           description="French thematic name"
      *         ),
      *         @OA\Property(
      *           property="name_en",
      *           type="string",
      *           example="Thematic 1",
      *           description="English thematic name"
      *         ),
      *         @OA\Property(
      *           property="ranking",
      *           type="integer",
      *           example=10,
      *           description="Rank for this thematic"
      *         )
      *       )
      *     )
      *   ),
      *   @OA\Response(response="200", description="Success"),
      *   @OA\Response(response="401", description="You are not allowed to update a thematic"),
      *   security={
      *     {"jwt": {}}
      *   }
      * )
      */
      $this->thematics->update($request->all(), $id);
      return response()->json(['status'=>'success','message'=>'Thematic modified']);
    }

    public function destroy($id)
    {
      /**
      * Delete a thematic
      * @OA\Delete(
      *   path="/admin/thematics/{id}",
      *   tags={"Thematics"},
      *   @OA\Parameter(
      *     name="id",
      *     description="Thematic id",
      *     required=true,
      *     in="path",
      *     @OA\Schema(type="integer")
      *   ),
      *   @OA\Response(response="200", description="Success"),
      *   @OA\Response(response="401", description="You are not allowed to delete this thematic"),
      *   security={
      *     {"jwt": {}}
      *   }
      * )
      */
      $this->thematics->destroy($id);
      return response()->json(['status'=>'success','message'=>'Thematic deleted']);
    }
}