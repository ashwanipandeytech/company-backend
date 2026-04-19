<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Project extends Model
{
    protected $fillable = [
        'client_id', 
        'title', 
        'slug', 
        'description', 
        'thumbnail_url', 
        'status'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    // protected function thumbnailUrl(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn () => $this->thumbnail ? asset('storage/' . $this->thumbnail) : null,
    //     );
    // }
}