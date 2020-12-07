<?php

namespace App\Http\Resources\V1\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'firstname' => $this->firstname,
      'name' => $this->name,
      'organization' => $this->organization,
      'email' => $this->email,
      'role' => new RoleResource($this->role)
    ];
  }
}