<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'thumbnail' => $this->thumbnail_url ? asset($this->thumbnail_url) : null,
            'status' => $this->status,
            // Safely conditionally load the relationship
            'client' => new ClientResource($this->whenLoaded('client')), 
        ];
    }
}