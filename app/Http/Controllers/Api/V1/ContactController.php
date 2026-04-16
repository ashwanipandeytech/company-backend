<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Public\StoreContactRequest;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request): JsonResponse
    {
        // Keeping it simple here. In a larger app, you'd inject a ContactService.
        Contact::create($request->validated());

        return $this->successResponse(
            null, 
            'Thank you for reaching out. We will get back to you soon.', 
            201
        );
    }
}