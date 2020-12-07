<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class EventListResource extends JsonResource
{
 
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'title_fr' => $this->title_fr,
      'title_en' => $this->title_en
    ];
  }
}