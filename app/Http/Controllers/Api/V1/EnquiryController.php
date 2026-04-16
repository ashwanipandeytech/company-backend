<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Public\StoreEnquiryRequest;
use App\Services\EnquiryService;
use Illuminate\Http\JsonResponse;

class EnquiryController extends Controller
{
    public function __construct(
        private readonly EnquiryService $enquiryService
    ) {}

    public function store(StoreEnquiryRequest $request): JsonResponse
    {
        $enquiry = $this->enquiryService->createEnquiry($request->validated());

        return $this->successResponse(
            ['id' => $enquiry->id], 
            'Your project enquiry has been submitted successfully.', 
            201
        );
    }
}