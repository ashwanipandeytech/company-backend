<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        $projects = Project::with('client:id,name')->whereIn('status', ['completed', 'ongoing'])->get();
        
        return $this->successResponse(
            ProjectResource::collection($projects), 
            'Projects retrieved successfully.'
        );
    }
}