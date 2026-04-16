<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function index(): JsonResponse
    {
        $contacts = Contact::latest()->get();
        return $this->successResponse($contacts, 'Contacts retrieved.');
    }

    public function show(Contact $contact): JsonResponse
    {
        return $this->successResponse($contact, 'Contact details retrieved.');
    }

    public function markAsRead(Contact $contact): JsonResponse
    {
        $contact->update(['is_read' => true]);
        return $this->successResponse($contact, 'Contact marked as read.');
    }
}