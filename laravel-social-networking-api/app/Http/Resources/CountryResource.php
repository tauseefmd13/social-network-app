<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sortname' => $this->sortname,
            'name' => $this->name,
            'phonecode' => $this->phonecode,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // 'states' => StateResource::collection($this->whenLoaded('states')),
        ];
    }
}
