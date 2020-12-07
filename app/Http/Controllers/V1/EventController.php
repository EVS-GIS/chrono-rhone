<?php 
namespace App\Http\Controllers\V1;

use Illuminate\Routing\Controller;
use App\Http\Repositories\V1\EventRepository;
use App\Http\Resources\V1\EventResource;
use App\Http\Resources\V1\EventListResource;
use Illuminate\Http\Request;
use App\Http\Requests\V1\Event\CreateRequest;
use App\Http\Requests\V1\Event\UpdateRequest;
use App\Exports\EventsExport;

class EventController extends Controller
{
    protected $events;

    public function __construct(EventRepository $events)
    {
        $this->events = $events;
    }

    public function index()
    {
      /**
      * Get informations for all events paginated by 100
      *
      * @OA\Get(
      *     path="/events",
      *     tags={"Events"},
      *     @OA\Parameter(
      *       name="page",
      *       description="page number",
      *       in="query",
      *       @OA\Schema(type="integer")
      *     ),
      *     @OA\Response(response="200", description="Return all events"),
      * )
      */
      return EventResource::collection($this->events->index());
    }

    public function list()
    {
      /**
      * Get id and title for all events
      *
      * @OA\Get(
      *     path="/events/list",
      *     tags={"Events"},
      *     @OA\Response(response="200", description="Return id and title for all events"),
      * )
      */
      return EventListResource::collection($this->events->list());
    }

    public function show($id)
    {
      /**
      * Get informations for one event
      *
      * @OA\Get(
      *     path="/event/{id}",
      *     tags={"Events"},
      *     @OA\Parameter(
      *       name="id",
      *       description="Event id",
      *       required=true,
      *       in="path",
      *       @OA\Schema(type="integer")
      *     ),
      *     @OA\Response(response="200", description="Return an event"),
      * )
      */
      return new EventResource($this->events->find($id));
    }

    public function store(CreateRequest $request)
    {
      /**
      * Add new event
      * @OA\Post(
      *   path="/event",
      *   tags={"Events"},
      *   @OA\RequestBody(
      *     required=true,
      *      @OA\MediaType(
      *        mediaType="application/json",
      *        @OA\Schema(
      *         required={"title_fr", "start_year","theme","author_id"},    
      *         @OA\Property(
      *           property="title_fr",
      *           type="string",
      *           example="Mon évènement",
      *           description="french title"
      *         ),
      *         @OA\Property(
      *           property="title_en",
      *           type="string",
      *           example="My event",
      *           description="English title"
      *         ),
      *         @OA\Property(
      *           property="start_year",
      *           type="integer",
      *           example=1900,
      *           description="Start year of the event"
      *         ),
      *         @OA\Property(
      *           property="start_month",
      *           type="integer",
      *           example=0,
      *           description="Start month of the event"
      *         ),
      *         @OA\Property(
      *           property="start_day",
      *           type="integer",
      *           example=1,
      *           description="Start day of the event"
      *         ),
      *         @OA\Property(
      *           property="end_year",
      *           type="integer",
      *           example=1900,
      *           description="End year of the event"
      *         ),
      *         @OA\Property(
      *           property="end_month",
      *           type="integer",
      *           example=1,
      *           description="End month of the event"
      *         ),
      *         @OA\Property(
      *           property="end_day",
      *           type="integer",
      *           example=1,
      *           description="End day of the event"
      *         ),
      *         @OA\Property(
      *           property="description_fr",
      *           type="string",
      *           example="Ma description",
      *           description="French description"
      *         ),
      *         @OA\Property(
      *           property="description_en",
      *           type="string",
      *           example="My description",
      *           description="English description"
      *         ),
      *         @OA\Property(
      *           property="bibliography_fr",
      *           type="string",
      *           example="Ma bibliographie",
      *           description="French bibliography"
      *         ),
      *         @OA\Property(
      *           property="bibliography_en",
      *           type="string",
      *           example="My bibliography",
      *           description="English bibliography"
      *         ),
      *         @OA\Property(
      *           property="km_up",
      *           type="numeric",
      *           example=0,
      *           description="Kilometer upstream"
      *         ),
      *         @OA\Property(
      *           property="km_down",
      *           type="numeric",
      *           example=50.1,
      *           description="Kilometer downstream"
      *         ),
      *         @OA\Property(
      *           property="theme",
      *           type="json",
      *           example={"id":1},
      *           description="Theme Id"
      *         ),
      *         @OA\Property(
      *           property="author_id",
      *           type="integer",
      *           example=1,
      *           description="Author Id"
      *         ),
      *         @OA\Property(
      *           property="points",
      *           type="object",
      *           description="Multipoint geometry based on geojson nomenclature",
      *             @OA\Property(
      *               property="type",
      *               type="string",
      *               example="MultiPoint"
      *             ),
      *             @OA\Property(
      *               property="coordinates",
      *               type="array",
      *               @OA\Items(type="number"),
      *               example={{4.05,45.50}}
      *             )
      *         ),
      *         @OA\Property(
      *           property="lines",
      *           type="object",
      *           description="Multilinestring geometry based on geojson nomenclature",
      *           @OA\Property(
      *             property="type",
      *             type="string",
      *             example="MultiLineString"
      *           ),
      *           @OA\Property(
      *             property="coordinates",
      *             type="array",
      *             @OA\Items(type="number"),
      *             example={{{1.76,44.46},{2.58,45.78},{5.29,44.94},{5.75,44.66}}}
      *           )
      *         ),
      *         @OA\Property(
      *           property="polygons",
      *           type="object",
      *           description="Multipolygon geometry based on geojson nomenclature",
      *           @OA\Property(
      *             property="type",
      *             type="string",
      *             example="MultiPolygon"
      *           ),
      *           @OA\Property(
      *             property="coordinates",
      *             type="array",
      *             @OA\Items(type="number"),
      *             example={{{{4.28,45.87},{5.38,45.89},{5.30,44.21},{4.331,44.36},{4.28,45.87}}}}
      *           )
      *         ),
      *         @OA\Property(
      *           property="from_events",
      *           type="array",
      *           description="Parent relationships to this event",
      *           @OA\Items(
      *             @OA\Property(
      *               property="id",
      *               type="integer",
      *               description="Parent event Id",
      *               example=1
      *             ),
      *             @OA\Property(
      *               property="relationship_id",
      *               type="integer",
      *               description="Relationship Id",
      *               example=1
      *             )
      *           )
      *         ),
      *         @OA\Property(
      *           property="to_events",
      *           type="array",
      *           description="Children relationships to this event",
      *           @OA\Items(
      *             @OA\Property(
      *               property="id",
      *               type="integer",
      *               description="children event Id",
      *               example=2
      *             ),
      *             @OA\Property(
      *               property="relationship_id",
      *               type="integer",
      *               description="Relationship Id",
      *               example=1
      *             )
      *           )
      *         )
      *       )
      *     )
      *   ),
      *   @OA\Response(response="200", description="Success"),
      *   @OA\Response(response="401", description="You are not allowed to create an event"),
      *   security={
      *     {"jwt": {}}
      *   }
      * )
      */
      $this->events->store($request->all());
      return response()->json(['status'=>'success','message'=>'Event created']);
    }

    public function update(UpdateRequest $request, $id)
    {
      /**
      * Update an event
      * @OA\Put(
      *   path="/event/{id}",
      *   tags={"Events"},
      *   @OA\Parameter(
      *     name="id",
      *     description="Event id",
      *     required=true,
      *     in="path",
      *     @OA\Schema(type="integer")
      *   ),
      *   @OA\RequestBody(
      *     required=true,
      *      @OA\MediaType(
      *        mediaType="application/json",
      *        @OA\Schema(
      *         required={"title_fr", "start_year","theme","author_id"},    
      *         @OA\Property(
      *           property="title_fr",
      *           type="string",
      *           example="Mon évènement",
      *           description="french title"
      *         ),
      *         @OA\Property(
      *           property="title_en",
      *           type="string",
      *           example="My event",
      *           description="English title"
      *         ),
      *         @OA\Property(
      *           property="start_year",
      *           type="integer",
      *           example=1900,
      *           description="Start year of the event"
      *         ),
      *         @OA\Property(
      *           property="start_month",
      *           type="integer",
      *           example=0,
      *           description="Start month of the event"
      *         ),
      *         @OA\Property(
      *           property="start_day",
      *           type="integer",
      *           example=1,
      *           description="Start day of the event"
      *         ),
      *         @OA\Property(
      *           property="end_year",
      *           type="integer",
      *           example=1900,
      *           description="End year of the event"
      *         ),
      *         @OA\Property(
      *           property="end_month",
      *           type="integer",
      *           example=1,
      *           description="End month of the event"
      *         ),
      *         @OA\Property(
      *           property="end_day",
      *           type="integer",
      *           example=1,
      *           description="End day of the event"
      *         ),
      *         @OA\Property(
      *           property="description_fr",
      *           type="string",
      *           example="Ma description",
      *           description="French description"
      *         ),
      *         @OA\Property(
      *           property="description_en",
      *           type="string",
      *           example="My description",
      *           description="English description"
      *         ),
      *         @OA\Property(
      *           property="bibliography_fr",
      *           type="string",
      *           example="Ma bibliographie",
      *           description="French bibliography"
      *         ),
      *         @OA\Property(
      *           property="bibliography_en",
      *           type="string",
      *           example="My bibliography",
      *           description="English bibliography"
      *         ),
      *         @OA\Property(
      *           property="km_up",
      *           type="numeric",
      *           example=0,
      *           description="Kilometer upstream"
      *         ),
      *         @OA\Property(
      *           property="km_down",
      *           type="numeric",
      *           example=50.1,
      *           description="Kilometer downstream"
      *         ),
      *         @OA\Property(
      *           property="theme",
      *           type="json",
      *           example={"id":1},
      *           description="Theme Id"
      *         ),
      *         @OA\Property(
      *           property="author_id",
      *           type="integer",
      *           example=1,
      *           description="Author Id"
      *         ),
      *         @OA\Property(
      *           property="points",
      *           type="object",
      *           description="Multipoint geometry based on geojson nomenclature",
      *             @OA\Property(
      *               property="type",
      *               type="string",
      *               example="MultiPoint"
      *             ),
      *             @OA\Property(
      *               property="coordinates",
      *               type="array",
      *               @OA\Items(type="number"),
      *               example={{4.05,45.50}}
      *             )
      *         ),
      *         @OA\Property(
      *           property="lines",
      *           type="object",
      *           description="Multilinestring geometry based on geojson nomenclature",
      *           @OA\Property(
      *             property="type",
      *             type="string",
      *             example="MultiLineString"
      *           ),
      *           @OA\Property(
      *             property="coordinates",
      *             type="array",
      *             @OA\Items(type="number"),
      *             example={{{1.76,44.46},{2.58,45.78},{5.29,44.94},{5.75,44.66}}}
      *           )
      *         ),
      *         @OA\Property(
      *           property="polygons",
      *           type="object",
      *           description="Multipolygon geometry based on geojson nomenclature",
      *           @OA\Property(
      *             property="type",
      *             type="string",
      *             example="MultiPolygon"
      *           ),
      *           @OA\Property(
      *             property="coordinates",
      *             type="array",
      *             @OA\Items(type="number"),
      *             example={{{{4.28,45.87},{5.38,45.89},{5.30,44.21},{4.331,44.36},{4.28,45.87}}}}
      *           )
      *         ),
      *         @OA\Property(
      *           property="from_events",
      *           type="array",
      *           description="Parent relationships to this event",
      *           @OA\Items(
      *             @OA\Property(
      *               property="id",
      *               type="integer",
      *               description="Parent event Id",
      *               example=1
      *             ),
      *             @OA\Property(
      *               property="relationship_id",
      *               type="integer",
      *               description="Relationship Id",
      *               example=1
      *             )
      *           )
      *         ),
      *         @OA\Property(
      *           property="to_events",
      *           type="array",
      *           description="Children relationships to this event",
      *           @OA\Items(
      *             @OA\Property(
      *               property="id",
      *               type="integer",
      *               description="children event Id",
      *               example=2
      *             ),
      *             @OA\Property(
      *               property="relationship_id",
      *               type="integer",
      *               description="Relationship Id",
      *               example=1
      *             )
      *           )
      *         )
      *       )
      *     )
      *   ),
      *   @OA\Response(response="200", description="Success"),
      *   @OA\Response(response="401", description="You are not allowed to update an event"),
      *   security={
      *     {"jwt": {}}
      *   }
      * )
      */
      $this->events->update($request->all(), $id);
      return response()->json(['status'=>'success','message'=>'Event modified']);
    }
    
    public function update_user(Request $request,$id)
    {
      $this->events->update_user($request->all(),$id);
      return response()->json(['status'=>'success','message'=>'User for these events modified']);
    }

    public function destroy($id)
    {
      /**
      * Delete an event
      * @OA\Delete(
      *   path="/event/{id}",
      *   tags={"Events"},
      *   @OA\Parameter(
      *     name="id",
      *     description="Event id",
      *     required=true,
      *     in="path",
      *     @OA\Schema(type="integer")
      *   ),
      *   @OA\Response(response="200", description="Success"),
      *   @OA\Response(response="401", description="You are not allowed to delete this event"),
      *   security={
      *     {"jwt": {}}
      *   }
      * )
      */
      $this->events->destroy($id);
      return response()->json(['status'=>'success','message'=>'Event deleted']);
    }

    public function export(Request $request)
	  {
      /**
      * Export events
      * @OA\Post(
      *   path="/events/export",
      *   tags={"Events"},
      *   @OA\RequestBody(
      *     required=true,
      *     @OA\MediaType(
      *       mediaType="application/json",
      *       @OA\Schema(
      *         required={"ids", "type"},
      *         @OA\Property(
      *           property="ids",
      *           type="array",
      *           description="Id list of events to download",
      *           @OA\Items(type="number"),
      *           example={1,2,3,4,5}
      *         ),    
      *         @OA\Property(
      *           property="type",
      *           type="string",
      *           example="xlsx",
      *           description="type of file downloaded (choice between xlsx, xls and csv)"
      *         )
      *       )
      *     )
      *   ),
      *   @OA\Response(response="200", description="File export")
      * )
      */
      $ids = $request->ids;
      $type = $request->type;
      return (new EventsExport($ids))->download('events.'.$type);
    }

    public function geojson(Request $request)
	  {
      /**
      * Export events in geojson format
      * @OA\Post(
      *   path="/events/geojson",
      *   tags={"Events"},
      *   @OA\RequestBody(
      *     required=true,
      *     @OA\MediaType(
      *       mediaType="application/json",
      *       @OA\Schema(
      *         required={"ids"},
      *         @OA\Property(
      *           property="ids",
      *           type="array",
      *           description="Id list of events to download",
      *           @OA\Items(type="number"),
      *           example={1,2,3,4,5}
      *         )
      *       )
      *     )
      *   ),
      *   @OA\Response(response="200", description="Geojson file export")
      * )
      */
      $ids = $request->ids;
      $export = $this->events->geojson($ids);
		  return response()->json($export)->withHeaders(['Content-Type' => 'application/geojson','Content-Disposition' => 'attachment; filename=events.geojson']);
    }
}