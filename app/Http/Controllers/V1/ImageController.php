<?php 
namespace App\Http\Controllers\V1;

use Illuminate\Routing\Controller;
use App\Http\Repositories\V1\ImageRepository;
use App\Http\Resources\V1\ImageResource;
use Illuminate\Http\Request;
use App\Http\Requests\V1\Image\UploadRequest;
use App\Http\Requests\V1\Image\UpdateRequest;

class ImageController extends Controller
{
    protected $events;

    public function __construct(ImageRepository $images)
    {
        $this->images = $images;
    }

    public function index()
    {
       /**
      * Get informations for all images paginated by 100
      *
      * @OA\Get(
      *   path="/images",
      *   tags={"Images"},
      *   @OA\Parameter(
      *     name="page",
      *     description="page number",
      *     in="query",
      *     @OA\Schema(type="integer")
      *   ),
      *   @OA\Response(response="200", description="Return all images"),
      *   @OA\Response(response="401", description="You are not allowed to access this endpoint"),
      *   security={
      *     {"jwt": {}}
      *   }
      * )
      */
      return ImageResource::collection($this->images->index());
    }
    
    public function upload(UploadRequest $request)
    {
    /**
    * Upload an image
    *
    * @OA\Post(
    *   path="/upload/image",
    *   tags={"Images"},
    *   @OA\RequestBody(
    *     required=true,
    *     @OA\MediaType(
    *       mediaType="multipart/form-data",
    *       @OA\Schema(
    *         @OA\Property(
    *           description="Image to upload",
    *           property="file",
    *           type="file",
    *           format="binary",
    *         ),
    *         @OA\Property(
    *           property="legend_fr",
    *           type="string",
    *           example="My legend",
    *           description="French legend"
    *         ),
    *         @OA\Property(
    *           property="legend_en",
    *           type="string",
    *           example="My legend",
    *           description="English legend"
    *         ),
    *         @OA\Property(
    *           property="copyright",
    *           type="string",
    *           example="Copyright",
    *           description="Copyright for this image"
    *         ),
    *         @OA\Property(
    *           property="events",
    *           type="array",
    *           description="Events linked to this image",
    *           @OA\Items(
    *             @OA\Property(
    *               property="id",
    *               type="integer",
    *               description="Event Id",
    *               example=1
    *             )
    *           )
    *         ),
    *         required={"file","legend_fr","copyright"}
    *       )
    *     )
    *   ),
    *   @OA\Response(response="200", description="Success"),
    *   @OA\Response(response="401", description="You are not allowed to upload image"),
    *   security={
    *     {"jwt": {}}
    *   }
    * )
    */
      $this->images->upload($request->all());
      return response()->json(['status'=>'success','message'=>'Image uploaded']);
    }

    public function update(UpdateRequest $request, $id)
    {
          /**
    * Upload an image
    *
    * @OA\Put(
    *   path="/image/{id}",
    *   tags={"Images"},
    *   @OA\Parameter(
    *     name="id",
    *     description="Image id",
    *     required=true,
    *     in="path",
    *     @OA\Schema(type="integer")
    *   ),
    *   @OA\RequestBody(
    *     required=true,
    *     @OA\MediaType(
    *       mediaType="application/json",
    *       @OA\Schema(
    *         @OA\Property(
    *           property="legend_fr",
    *           type="string",
    *           example="My legend",
    *           description="French legend"
    *         ),
    *         @OA\Property(
    *           property="legend_en",
    *           type="string",
    *           example="My legend",
    *           description="English legend"
    *         ),
    *         @OA\Property(
    *           property="copyright",
    *           type="string",
    *           example="Copyright",
    *           description="Copyright for this image"
    *         ),
    *         @OA\Property(
    *           property="events",
    *           type="array",
    *           description="Events linked to this image",
    *           @OA\Items(       
    *             type="integer",
    *             description="Event Id",
    *             example=1
    *           )
    *         ),
    *         required={"legend_fr","copyright"}
    *       )
    *     )
    *   ),
    *   @OA\Response(response="200", description="Success"),
    *   @OA\Response(response="401", description="You are not allowed to upload image"),
    *   security={
    *     {"jwt": {}}
    *   }
    * )
    */
      $this->images->update($request->all(), $id);
      return response()->json(['status'=>'success','message'=>'Image modified']);
    }

    public function destroy($filename)
    {
      /**
      * Delete an image
      * @OA\Delete(
      *   path="/storage/{filename}",
      *   tags={"Images"},
      *   @OA\Parameter(
      *     name="filename",
      *     description="Image filename",
      *     required=true,
      *     in="path",
      *     @OA\Schema(type="string")
      *   ),
      *   @OA\Response(response="200", description="Success"),
      *   @OA\Response(response="401", description="You are not allowed to delete this event"),
      *   security={
      *     {"jwt": {}}
      *   }
      * )
      */
      $this->images->destroy($filename);
      return response()->json(['status'=>'success','message'=>'Image deleted']);
    }
}