<?php 

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Event;

class EventsSheet implements FromQuery, WithTitle, WithHeadings, WithMapping, ShouldAutoSize
{
  use Exportable;

  public function __construct(array $ids)
  {
     $this->ids = $ids;
  }
    
  public function query()
  {
    return  Event::query()->whereIn('id', $this->ids);    
  }

  public function title(): string
    {
        return 'Events';
    }

  public function map($event): array
  {
    $map = [
      $event->id,
      $event->title_fr,
      $event->title_en,
      $event->creator,
      $event->start_year,
      $event->start_month,
      $event->start_day,
      $event->end_year,
      $event->end_month,
      $event->end_day,
      $event->images->map(function ($image){
        return $image->id;
      }),
      $event->description_fr,
      $event->description_en,
      $event->bibliography_fr,
      $event->bibliography_en,
      $event->km_up,
      $event->km_down,
      $event->theme->thematic->id,
      $event->theme->thematic->name_fr,
      $event->theme->thematic->name_en,
      $event->theme->id,
      $event->theme->name_fr,
      $event->theme->name_en,
      $event->user->firstname,
      $event->user->name
    ];
    
    return $map;
  }

  public function headings(): array
  {
    $headings = [
      'id',
      'title_fr',
      'title_en',
      'creator',
      'start_year',
      'start_month',
      'start_day',
      'end_year',
      'end_month',
      'end_day',
      'images',
      'description_fr',
      'description_en',
      'bibliography_fr',
      'bibliography_en',
      'km_up',
      'km_down',
      'thematic_id',
      'thematic_fr',
      'thematic_en',
      'theme_id',
      'theme_fr',
      'theme_en',
      'author_firstname',
      'author_name'
    ]; 
    return $headings;
  }
}

