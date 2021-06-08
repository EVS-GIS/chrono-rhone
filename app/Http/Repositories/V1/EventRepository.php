<?php namespace App\Http\Repositories\V1;

use App\Http\Repositories\BaseRepository;
use App\Models\Event;
use App\Models\Eventrelationship;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewEvent;

class EventRepository extends BaseRepository
{
	public function __construct(Event $event)
	{
		$this->model =$event;
	}

	public function index()
	{
    return $this->model
      ->with('user','theme.thematic')
      ->select(array('events.id','title_fr','title_en','creator','start_year','start_month','start_day','end_year','end_month','end_day','description_fr','description_en','bibliography_fr','bibliography_en','km_up','km_down','theme_id','user_id',
      DB::raw('ST_AsGeoJSON(points,6) as points'),DB::raw('ST_AsGeoJSON(lines,6) as lines'),DB::raw('ST_AsGeoJSON(polygons,6) as polygons')))
      ->leftJoin('themes','themes.id','=','events.theme_id')
      ->orderBy('ranking','asc')
      ->orderBy('start_year','asc')
      ->paginate(100);
  }
  
  public function list()
	{
		return $this->model->get();
	}

	public function find($id)
	{
		return $this->model->with('user','theme.thematic')->findOrFail($id,array('id','title_fr','title_en','creator','start_year','start_month','start_day','end_year','end_month','end_day','description_fr','description_en','bibliography_fr','bibliography_en','km_up','km_down','theme_id','user_id',
    DB::raw('ST_AsGeoJSON(points,6) as points'),DB::raw('ST_AsGeoJSON(lines,6) as lines'),DB::raw('ST_AsGeoJSON(polygons,6) as polygons')));
	}

	public function store($inputs)
	{
	  $event = new $this->model;
    $event->fill($inputs);
    $event->theme_id = $inputs["theme"]['id'];
    $event->user_id = $inputs["author_id"];
    if(isset($inputs["points"])){
      $point = DB::select(DB::raw("select ST_GeomFromGeoJSON('".json_encode($inputs["points"])."') as geom;"));
      $event->points = $point[0]->geom;
    }
    if(isset($inputs["polygons"])){
      $polygon = DB::select(DB::raw("select ST_GeomFromGeoJSON('".json_encode($inputs["polygons"])."') as geom;"));
      $event->polygons = $polygon[0]->geom;
    }
    if(isset($inputs["lines"])){
      $line = DB::select(DB::raw("select ST_GeomFromGeoJSON('".json_encode($inputs["lines"])."') as geom;"));
      $event->lines = $line[0]->geom;
    }
    $event->save();
    if(isset($inputs["images"])){
      $data = [];
      foreach ($inputs["images"] as $image) {
        $data[] = $image['id'];
      }
      $event->images()->sync($data);
    }
    if(isset($inputs["from_events"])){
      $data = [];
      foreach ($inputs["from_events"] as $single_event) {
        $data[$single_event['id']] = ['relationship_id'=>$single_event['relationship_id']];
      }
      $event->from_events()->sync($data);
    }
    if(isset($inputs["to_events"])){
      $data = [];
      foreach ($inputs["to_events"] as $single_event) {
        $data[$single_event['id']] = ['relationship_id'=>$single_event['relationship_id']];
      }
      $event->to_events()->sync($data);
    }
    $admins = User::where('id','<>',$inputs["author_id"])->whereHas('role', function($q){ $q->where('slug','admin'); })->get();
    Notification::send($admins, new NewEvent($event));  
	}

	public function update($inputs, $id)
	{		
		$event = $this->model->find($id);
    $event->fill($inputs);
    $event->theme_id = $inputs["theme"]['id'];
    $event->user_id = $inputs["author_id"];
    if(isset($inputs["points"])){
      $point = DB::select(DB::raw("select ST_GeomFromGeoJSON('".json_encode($inputs["points"])."') as geom;"));
      $event->points = $point[0]->geom;
    }
    if(isset($inputs["polygons"])){
      $polygon = DB::select(DB::raw("select ST_GeomFromGeoJSON('".json_encode($inputs["polygons"])."') as geom;"));
      $event->polygons = $polygon[0]->geom;
    }
    if(isset($inputs["lines"])){
      $line = DB::select(DB::raw("select ST_GeomFromGeoJSON('".json_encode($inputs["lines"])."') as geom;"));
      $event->lines = $line[0]->geom;
    }
    $event->save();
    if(isset($inputs["images"])){
      $data = [];
      foreach ($inputs["images"] as $image) {
        $data[] = $image['id'];
      }
      $event->images()->sync($data);
    }
    if(isset($inputs["from_events"])){
      $data = [];
      foreach ($inputs["from_events"] as $single_event) {
        $data[$single_event['id']] = ['relationship_id'=>$single_event['relationship_id']];
      }
      $event->from_events()->sync($data);
    }
    if(isset($inputs["to_events"])){
      $data = [];
      foreach ($inputs["to_events"] as $single_event) {
        $data[$single_event['id']] = ['relationship_id'=>$single_event['relationship_id']];
      }
      $event->to_events()->sync($data);
    }    
  }
  
  public function update_user($inputs,$id)
  {
    $this->model->where("user_id", $id)->update(["user_id" => $inputs["new_user_id"]]); 
  }

  public function destroy($id)
	{
		$event = $this->model->find($id);
		$event->delete();
  }
  
  public function geojson($ids)
    {
      $fields = 'id,title_fr,title_en,creator,start_year,start_month,start_day,end_year,end_month,end_day,description_fr,description_en,bibliography_fr,bibliography_en,km_up,km_down';
      $a_fields = 'a.id,a.title_fr,a.title_en,creator,start_year,start_month,start_day,end_year,end_month,end_day,description_fr,description_en,bibliography_fr,bibliography_en,km_up,km_down';

      $ids = implode(', ', $ids);
      $geojson = DB::select(DB::raw("
        with selection as (
          select ".$fields.",theme_id, points as geom from events where points is not null and id in (".$ids.")
          union
          select ".$fields.",theme_id, lines as geom from events where lines is not null and id in (".$ids.")
          union
          select ".$fields.",theme_id, polygons as geom from events where polygons is not null and id in (".$ids.")
        ), images as(
          select a.id,json_agg(row_to_json(c)) as images,row_to_json(d) as theme from
          selection a
          left join event_image b on a.id = b.event_id
          left join (select id,concat('".config('app.url')."/storage/',filename) as url,legend_fr,legend_en,copyright from images) c on b.image_id = c.id
          left join (select id,name_fr,name_en from themes) d on a.theme_id = d.id
          group by a.id,d.*
        ), from_events as (
          select a.id,json_agg(row_to_json(c)) as from_events from selection a
          left join events_relationships b on a.id = b.to_event_id
          left join (
            select a.id,title_fr,title_en,relationship from events a
            left join events_relationships b on a.id = b.from_event_id
            left join (select id,json_build_object('id',id,'name_fr',name_fr,'name_en',name_en) as relationship from relationships) c on b.relationship_id = c.id
          ) c on b.from_event_id = c.id
          group by a.id
        ), to_events as (
          select a.id,json_agg(row_to_json(c)) as to_events from selection a
          left join events_relationships b on a.id = b.from_event_id
          left join (
            select a.id,title_fr,title_en,relationship from events a
            left join events_relationships b on a.id = b.to_event_id
            left join (select id,json_build_object('id',id,'name_fr',name_fr,'name_en',name_en) as relationship from relationships) c on b.relationship_id = c.id
          ) c on b.to_event_id = c.id
          group by a.id
        ), t as (
          select a.*,b.theme,b.images,c.from_events,d.to_events from selection a
          left join images b on a.id = b.id
          left join from_events c on a.id = c.id
          left join to_events d on a.id = d.id
        )
        select json_build_object('type', 'FeatureCollection','features', json_agg(ST_AsGeoJSON(t.*)::json))
          from t;"));
        return json_decode($geojson[0]->json_build_object);        
    }
}