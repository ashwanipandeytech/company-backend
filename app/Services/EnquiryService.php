<?php

namespace App\Services;

use App\Models\Enquiry;
use Illuminate\Support\Facades\Log;

class EnquiryService
{
    /**
     * Handle the creation of a new client enquiry.
     */
    public function createEnquiry(array $data): Enquiry
    {
        try {
            $enquiry = Enquiry::create($data);

            // Future expansion: Dispatch Mailable to Admin here
            // Future expansion: Push to RabbitMQ for CRM integration here

            return $enquiry;
        } catch (\Exception $e) {
            Log::error('Failed to create enquiry: ' . $e->getMessage());
            throw $e; 
        }
    }
}