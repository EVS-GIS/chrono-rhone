<?php 

namespace App\Imports\Sheets;

use App\Models\Eventrelationship;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EventsRelationshipsSheet implements ToCollection, WithHeadingRow
{
  public function collection(Collection $rows)
  {
    foreach ($rows as $row) 
    {
      $data = Eventrelationship::firstOrNew(['id' => $row['id']]);
      $data->id = $row['id'];
      $data->relationship_id = $row['relationship_id'];
      $data->from_event_id = $row['from_event_id'];
      $data->to_event_id = $row['to_event_id'];
      $data->save();
    }
    DB::statement("SELECT setval('events_relationships_id_seq', max(id)) FROM events_relationships;");
  }
}

