<?php

namespace App\Http\Resources\Detail;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Simple\{PermissionResource, RoleResource};

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
            'roles' => RoleResource::collection($this->whenLoaded('roles'))
        ];
    }
}
