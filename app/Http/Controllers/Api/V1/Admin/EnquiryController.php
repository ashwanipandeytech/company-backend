<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function index(): JsonResponse
    {
        // Eager load the project type to avoid N+1 issues
        $enquiries = Enquiry::with('projectType:id,name')->latest()->get();
        return $this->successResponse($enquiries, 'Enquiries retrieved.');
    }

    public function show(Enquiry $enquiry): JsonResponse
    {
        return $this->successResponse($enquiry->load('projectType:id,name'), 'Enquiry details retrieved.');
    }

    public function updateStatus(Request $request, Enquiry $enquiry): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,contacted,converted,closed']
        ]);

        $enquiry->update(['status' => $validated['status']]);

        return $this->successResponse($enquiry, 'Enquiry status updated.');
    }
}