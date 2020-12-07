<?php

namespace App\Http\Resources\V1\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ThemeResource extends JsonResource
{
 
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'name_fr' => $this->name_fr,
      'name_en' => $this->name_en,
      'ranking' => $this->ranking,
      'color' => $this->color,
      'thematic' => new ThematicResource($this->whenLoaded('thematic'))
    ];
  }
}