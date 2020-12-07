<?php

namespace App\Http\Resources\V1\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class RelationshipResource extends JsonResource
{
 
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'name_fr' => $this->name_fr,
      'name_en' => $this->name_en
    ];
  }
}