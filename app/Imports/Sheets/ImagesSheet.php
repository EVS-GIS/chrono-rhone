<?php 

namespace App\Imports\Sheets;

use App\Models\Image;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImagesSheet implements ToCollection, WithHeadingRow
{
  public function collection(Collection $rows)
  {
    foreach ($rows as $row) 
    {
      $data = Image::firstOrNew(['id' => $row['id']]);
      $data->id = $row['id'];
      $data->filename = $row['filename'];
      $data->legend_fr = $row['legend_fr'];
      $data->legend_en = $row['legend_en'];
      $data->copyright = $row['copyright'];
      $data->save();
    }
    DB::statement("SELECT setval('images_id_seq', max(id)) FROM images;");
  }
}

