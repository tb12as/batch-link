<?php

namespace App\Http\Resources;

use App\Http\Resources\LinkResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PasteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'privacy' => $this->privacy,
            'description' => $this->description,
            'links' => LinkResource::collection($this->whenLoaded('links')),
        ];
    }
}
