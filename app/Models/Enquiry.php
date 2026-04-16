<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enquiry extends Model
{
    protected $fillable = [
        'name', 
        'email', 
        'phone', 
        'company_name', 
        'project_type_id', 
        'budget_estimation', 
        'estimated_timeline', 
        'requirements', 
        'status'
    ];

    public function projectType(): BelongsTo
    {
        return $this->belongsTo(ProjectType::class);
    }
}
