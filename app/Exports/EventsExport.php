<?php 

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Exports\Sheets\EventsSheet;
use App\Exports\Sheets\RelationshipsSheet;
use App\Exports\Sheets\ImagesSheet;

class EventsExport implements WithMultipleSheets
{
  use Exportable;

  public function __construct(array $ids)
  {
     $this->ids = $ids;
  }
    
  public function sheets(): array
    {
      $sheets = [
        new EventsSheet($this->ids),
        new RelationshipsSheet($this->ids),
        new ImagesSheet($this->ids)
      ];
      return $sheets;
    }
}

