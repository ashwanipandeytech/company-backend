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
            'logo' => $this->logo_url ? asset('storage/' . $this->logo_url) : null,
            'website' => $this->website_url, 
        ];
    }
}