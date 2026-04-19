<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\StoreClientRequest;
use App\Http\Requests\Api\V1\Admin\UpdateClientRequest;
use App\Models\Client;
use App\Http\Resources\ClientResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(): JsonResponse
    {
        // Admins see ALL clients, not just active ones
        $clients = Client::latest()->get();
        return $this->successResponse(ClientResource::collection($clients), 'Admin clients retrieved.');
    }

   public function store(StoreClientRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            // Stores the file in storage/app/public/clients/logos
            // The path saved in the DB will be: clients/logos/filename.png
            $validated['logo_url'] = $request->file('logo')->store('clients/logos', 'public');
        }

        $client = Client::create($validated);

        return $this->successResponse(new ClientResource($client), 'Client created successfully.', 201);
    }
   

    public function show(Client $client): JsonResponse
    {
        return $this->successResponse(new ClientResource($client), 'Client retrieved.');
    }

    public function update(UpdateClientRequest $request, Client $client): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            // Optional but recommended: Delete the old logo to save disk space
            if ($client->logo_url) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($client->logo_url);
            }
            
            $validated['logo_url'] = $request->file('logo')->store('clients/logos', 'public');
        }

        $client->update($validated);

        return $this->successResponse(new ClientResource($client), 'Client updated successfully.');
    }

    public function destroy(Client $client): JsonResponse
    {
        $client->delete();
        return $this->successResponse(null, 'Client deleted successfully.');
    }
}