<?php 

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Eventrelationship;

class RelationshipsSheet implements FromQuery, WithTitle, WithHeadings, WithMapping, ShouldAutoSize
{
  use Exportable;

  public function __construct(array $ids)
  {
     $this->ids = $ids;
  }
    
  public function query()
  {
    return  Eventrelationship::query()->whereIn('from_event_id', $this->ids)->orWhereIn('from_event_id', $this->ids);    
  }

  public function title(): string
    {
        return 'Relationships';
    }

  public function map($relationship): array
  {
    $map = [
      $relationship->id,
      $relationship->relationship->id,
      $relationship->relationship->name_fr,
      $relationship->relationship->name_en,
      $relationship->from_event_id,
      $relationship->to_event_id
    ];
    
    return $map;
  }

  public function headings(): array
  {
    $headings = [
      'id',
      'relationship_id',
      'relationship_fr',
      'relationship_en',
      'from_event_id',
      'to_event_id'
    ]; 
    return $headings;
  }
}

