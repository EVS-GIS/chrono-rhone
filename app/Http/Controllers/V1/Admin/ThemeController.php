<?php 
namespace App\Http\Controllers\V1\Admin;

use Illuminate\Routing\Controller;
use App\Http\Repositories\V1\Admin\ThemeRepository;
use App\Http\Resources\V1\Admin\ThemeResource;
use Illuminate\Http\Request;
use App\Http\Requests\V1\Admin\Theme\CreateRequest;
use App\Http\Requests\V1\Admin\Theme\UpdateRequest;

class ThemeController extends Controller
{
    protected $themes;

    public function __construct(ThemeRepository $themes)
    {
      $this->themes = $themes;
    }

    public function index()
    {
      /**
      * Get informations for all themes
      * @OA\Get(
      *   path="/themes",
      *   tags={"Themes"},
      *   @OA\Response(response="200", description="Return all themes"),
      *   @OA\Response(response="401", description="You are not allowed to access this endpoint"),
      *   security={
      *     {"jwt": {}}
      *   }
      * )
      */
      return ThemeResource::collection($this->themes->index());
    }

    public function show($id)
    {
      /**
      * Get informations for one theme
      *
      * @OA\Get(
      *     path="/admin/themes/{id}",
      *     tags={"Themes"},
      *     @OA\Parameter(
      *       name="id",
      *       description="Theme id",
      *       required=true,
      *       in="path",
      *       @OA\Schema(type="integer")
      *     ),
      *     @OA\Response(response="200", description="Return theme informations"),
      *     @OA\Response(response="401", description="You are not allowed to access this endpoint"),
      *     security={
      *       {"jwt": {}}
      *     }
      * )
      */
      return new ThemeResource($this->themes->find($id));
    }

    public function store(CreateRequest $request)
    {
      /**
      * Add new theme
      * @OA\Post(
      *   path="/admin/themes",
      *   tags={"Themes"},
      *   @OA\RequestBody(
      *     required=true,
      *      @OA\MediaType(
      *        mediaType="application/json",
      *        @OA\Schema(
      *         required={"name_fr", "name_en","ranking","color","thematic_id"},    
      *         @OA\Property(
      *           property="name_fr",
      *           type="string",
      *           example="Theme 1",
      *           description="French theme name"
      *         ),
      *         @OA\Property(
      *           property="name_en",
      *           type="string",
      *           example="Theme 1",
      *           description="English theme name"
      *         ),
      *         @OA\Property(
      *           property="color",
      *           type="string",
      *           example="#ffffff",
      *           description="Hexadecimal code color for this theme"
      *         ),
      *         @OA\Property(
      *           property="ranking",
      *           type="integer",
      *           example=10,
      *           description="Rank for this theme"
      *         ),
      *         @OA\Property(
      *           property="thematic_id",
      *           type="integer",
      *           example=1,
      *           description="Thematic Id for this theme"
      *         )
      *       )
      *     )
      *   ),
      *   @OA\Response(response="200", description="Success"),
      *   @OA\Response(response="401", description="You are not allowed to create a theme"),
      *   security={
      *     {"jwt": {}}
      *   }
      * )
      */      
      $this->themes->store($request->all());
      return response()->json(['status'=>'success','message'=>'Theme created']);
    }

    public function update(UpdateRequest $request, $id)
    {
     /**
      * Update a theme
      * @OA\Put(
      *   path="/admin/themes/{id}",
      *   tags={"Themes"},
      *   @OA\Parameter(
      *     name="id",
      *     description="Theme id",
      *     required=true,
      *     in="path",
      *     @OA\Schema(type="integer")
      *   ),
      *   @OA\RequestBody(
      *     required=true,
      *      @OA\MediaType(
      *        mediaType="application/json",
      *        @OA\Schema(
      *         required={"name_fr", "name_en","ranking","color","thematic_id"},    
      *         @OA\Property(
      *           property="name_fr",
      *           type="string",
      *           example="Theme 1",
      *           description="French theme name"
      *         ),
      *         @OA\Property(
      *           property="name_en",
      *           type="string",
      *           example="Theme 1",
      *           description="English theme name"
      *         ),
      *         @OA\Property(
      *           property="color",
      *           type="string",
      *           example="#ffffff",
      *           description="Hexadecimal code color for this theme"
      *         ),
      *         @OA\Property(
      *           property="ranking",
      *           type="integer",
      *           example=10,
      *           description="Rank for this theme"
      *         ),
      *         @OA\Property(
      *           property="thematic_id",
      *           type="integer",
      *           example=1,
      *           description="Thematic Id for this theme"
      *         )
      *       )
      *     )
      *   ),
      *   @OA\Response(response="200", description="Success"),
      *   @OA\Response(response="401", description="You are not allowed to update a theme"),
      *   security={
      *     {"jwt": {}}
      *   }
      * )
      */
      $this->themes->update($request->all(), $id);
      return response()->json(['status'=>'success','message'=>'Theme modified']);
    }

    public function destroy($id)
    {
      /**
      * Delete a theme
      * @OA\Delete(
      *   path="/admin/themes/{id}",
      *   tags={"Themes"},
      *   @OA\Parameter(
      *     name="id",
      *     description="Theme id",
      *     required=true,
      *     in="path",
      *     @OA\Schema(type="integer")
      *   ),
      *   @OA\Response(response="200", description="Success"),
      *   @OA\Response(response="401", description="You are not allowed to delete this theme"),
      *   security={
      *     {"jwt": {}}
      *   }
      * )
      */
      $this->themes->destroy($id);
      return response()->json(['status'=>'success','message'=>'Theme deleted']);
    }
}