<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

final class UserResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
        ];
    }
}
