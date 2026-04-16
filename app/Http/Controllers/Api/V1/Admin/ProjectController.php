<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\StoreProjectRequest;
use App\Http\Requests\Api\V1\Admin\UpdateProjectRequest;
use App\Models\Project;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        $projects = Project::with('client:id,name')->latest()->get();
        return $this->successResponse(ProjectResource::collection($projects), 'Admin projects retrieved.');
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail_url'] = $request->file('thumbnail')->store('projects/thumbnails', 'public');
        }

        $project = Project::create($validated);

        return $this->successResponse(new ProjectResource($project->load('client')), 'Project created successfully.', 201);
    }

    public function show(Project $project): JsonResponse
    {
        return $this->successResponse(new ProjectResource($project->load('client')), 'Project retrieved.');
    }

    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail_url) {
                Storage::disk('public')->delete($project->thumbnail_url);
            }
            $validated['thumbnail_url'] = $request->file('thumbnail')->store('projects/thumbnails', 'public');
        }

        $project->update($validated);

        return $this->successResponse(new ProjectResource($project->load('client')), 'Project updated successfully.');
    }

    public function destroy(Project $project): JsonResponse
    {
        if ($project->thumbnail_url) {
            Storage::disk('public')->delete($project->thumbnail_url);
        }
        $project->delete();
        return $this->successResponse(null, 'Project deleted successfully.');
    }
}