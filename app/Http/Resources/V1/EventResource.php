<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
 
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'title_fr' => $this->title_fr,
      'title_en' => $this->title_en,
      'creator' => $this->creator,
      'start_year'=> $this->start_year,
      'start_month'=> $this->start_month,
      'start_day'=> $this->start_day,
      'end_year'=> $this->end_year,
      'end_month'=> $this->end_month,
      'end_day'=> $this->end_day,
      'description_fr'=> $this->description_fr,
      'description_en'=> $this->description_en,
      'bibliography_fr'=> $this->bibliography_fr,
      'bibliography_en'=> $this->bibliography_en,
      'km_up'=> $this->km_up,
      'km_down'=> $this->km_down,
      'theme'=> new Admin\ThemeResource($this->theme),
      'author_id' => $this->user->id,
      'images' => ImageResource::collection($this->images),
      'points'=> json_decode($this->points),
      'lines'=> json_decode($this->lines),
      'polygons' => json_decode($this->polygons),
      'from_events' => EventrelationshipResource::collection($this->from_events),
      'to_events' => EventrelationshipResource::collection($this->to_events),
    ];
  }
}