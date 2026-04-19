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
            // Use the exact DB column name from your screenshot
            'thumbnail' => $this->thumbnail_url ? asset('storage/' . $this->thumbnail_url) : null,
            'status' => $this->status,
            'client' => new ClientResource($this->whenLoaded('client')), 
        ];
    }
}