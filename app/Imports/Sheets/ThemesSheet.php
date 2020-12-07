<?php 

namespace App\Imports\Sheets;

use App\Models\Theme;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ThemesSheet implements ToCollection, WithHeadingRow
{
  public function collection(Collection $rows)
  {
    foreach ($rows as $row) 
    {
      $data = Theme::firstOrNew(['id' => $row['id']]);
      $data->id = $row['id'];
      $data->name_fr = $row['name_fr'];
      $data->name_en = $row['name_en'];
      $data->ranking = $row['ranking'];
      $data->color = $row['color'];
      $data->thematic_id = $row['thematic_id'];
      $data->save();
    }
    DB::statement("SELECT setval('themes_id_seq', max(id)) FROM themes;");
  }
}

