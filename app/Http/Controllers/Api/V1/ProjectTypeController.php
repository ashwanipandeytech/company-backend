<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ProjectType;
use Illuminate\Http\JsonResponse;

class ProjectTypeController extends Controller
{
    public function index(): JsonResponse
    {
        $types = ProjectType::where('is_active', true)->select('id', 'name')->get();
        
        return $this->successResponse(
            $types, 
            'Project types retrieved successfully.'
        );
    }
}