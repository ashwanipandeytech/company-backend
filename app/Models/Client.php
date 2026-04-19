<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Client extends Model
{
    protected $fillable = [
        'name', 
        'logo_url', 
        'website_url', 
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    // protected function logoUrl(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn () => $this->logo ? asset('storage/' . $this->logo) : null,
    //     );
    // }
}