<?php

namespace App\Http\Resources\V1\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'slug' => $this->slug,
      'name' => $this->name   
    ];
  }
}
