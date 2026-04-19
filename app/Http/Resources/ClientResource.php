<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            // Check the raw DB column ($this->logo). If it exists, build the URL.
            'logo' => $this->logo ? asset('storage/' . $this->logo) : null,
            'website' => $this->website_url, // Make sure this matches your DB column exactly
        ];
    }
}