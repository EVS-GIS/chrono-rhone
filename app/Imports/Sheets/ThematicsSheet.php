<?php 

namespace App\Imports\Sheets;

use App\Models\Thematic;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ThematicsSheet implements ToCollection, WithHeadingRow
{
  public function collection(Collection $rows)
  {
    foreach ($rows as $row) 
    {
      $data = Thematic::firstOrNew(['id' => $row['id']]);
      $data->id = $row['id'];
      $data->name_fr = $row['name_fr'];
      $data->name_en = $row['name_en'];
      $data->ranking = $row['ranking'];
      $data->save();
    }
    DB::statement("SELECT setval('thematics_id_seq', max(id)) FROM thematics;");
  }
}

