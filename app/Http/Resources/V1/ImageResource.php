<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
 
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'filename' => $this->filename,
      'legend_fr' => $this->legend_fr,
      'legend_en' => $this->legend_en,
      'copyright' => $this->copyright,
      'events' => EventListResource::collection($this->events),
    ];
  }
}