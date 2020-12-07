<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Imports\Sheets\ThematicsSheet;
use App\Imports\Sheets\ThemesSheet;
use App\Imports\Sheets\ImagesSheet;
use App\Imports\Sheets\EventsSheet;
use App\Imports\Sheets\RelationshipsSheet;
use App\Imports\Sheets\EventsRelationshipsSheet;


class DatabaseImport implements WithMultipleSheets
{
  public function sheets(): array
  {
    return [
      'Thematics' => new ThematicsSheet(),
      'Themes' => new ThemesSheet(),
      'Images' => new ImagesSheet(),
      'Events' => new EventsSheet(),
      'Relationships' => new RelationshipsSheet(),
      'Events_Relationships' => new EventsRelationshipsSheet()
    ];
  }
}
