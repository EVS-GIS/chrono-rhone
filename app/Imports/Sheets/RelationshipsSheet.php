<?php 

namespace App\Imports\Sheets;

use App\Models\Relationship;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RelationshipsSheet implements ToCollection, WithHeadingRow
{
  public function collection(Collection $rows)
  {
    foreach ($rows as $row) 
    {
      $data = Relationship::firstOrNew(['id' => $row['id']]);
      $data->id = $row['id'];
      $data->name_fr = $row['name_fr'];
      $data->name_en = $row['name_en'];
      $data->save();
    }
    DB::statement("SELECT setval('relationships_id_seq', max(id)) FROM relationships;");
  }
}

