<?php 

namespace App\Imports\Sheets;

use App\Models\Event;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class EventsSheet implements ToCollection, WithHeadingRow
{
  public function collection(Collection $rows)
  {
    foreach ($rows as $row) 
    {
      $data = Event::firstOrNew(['id' => $row['id']]);
      $data->id = $row['id'];
      $data->title_fr = $row['title_fr'];
      $data->title_en = $row['title_en'];
      $data->creator = $row['creator'];
      $data->start_year = $row['start_year'];
      $data->start_month = $row['start_month'];
      $data->start_day = $row['start_day']; 
      $data->end_year = $row['end_year'];
      $data->end_month = $row['end_month'];
      $data->end_day = $row['end_day'];
      $data->description_fr = $row['description_fr'];
      $data->description_en = $row['description_en'];
      $data->bibliography_fr = $row['bibliography_fr'];
      $data->bibliography_en = $row['bibliography_en'];
      $data->km_up = $row['km_up'];
      $data->km_down = $row['km_down']; 
      $data->theme_id = $row['theme_id'];
      $data->user_id = $row['user_id'];
      if($row['points']){
        $points = DB::select(DB::raw("select ST_GeomFromGeoJSON('".$row['points']."') as geom;"));
        $data->points = $points[0]->geom;
      }
      if($row['lines']){
        $lines = DB::select(DB::raw("select ST_GeomFromGeoJSON('".$row['lines']."') as geom;"));
        $data->lines = $lines[0]->geom;
      }
      if($row['polygons']){
        $polygons = DB::select(DB::raw("select ST_GeomFromGeoJSON('".$row['polygons']."') as geom;"));
        $data->polygons = $polygons[0]->geom;
      }
      $data->save();
      if($row['images']){
        $images = str_getcsv($row['images'],',');
        $data->images()->sync($images);
      }
    }
    DB::statement("SELECT setval('events_id_seq', max(id)) FROM events;");
  }
}

