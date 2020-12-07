<?php 

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Image;

class ImagesSheet implements FromQuery, WithTitle, WithHeadings, WithMapping, ShouldAutoSize
{
  use Exportable;

  public function __construct(array $ids)
  {
     $this->ids = $ids;
  }
    
  public function query()
  {
    return  Image::query()->whereHas('events', function($q){ $q->whereIn('event_id',$this->ids);});    
  }

  public function title(): string
    {
        return 'Images';
    }

  public function map($image): array
  {
    $map = [
      $image->id,
      $image->filename,
      config('app.url')."/storage/".$image->filename,
      $image->legend_fr,
      $image->legend_en,
      $image->copyright
    ];
    
    return $map;
  }

  public function headings(): array
  {
    $headings = [
      'id',
      'filename',
      'url',
      'legend_fr',
      'legend_en',
      'copyright',
    ]; 
    return $headings;
  }
}

