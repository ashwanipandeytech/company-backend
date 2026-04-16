<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Http\Resources\ClientResource;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    public function index(): JsonResponse
    {
        $clients = Client::where('is_active', true)->get();
        
        return $this->successResponse(
            ClientResource::collection($clients), 
            'Clients retrieved successfully.'
        );
    }
}