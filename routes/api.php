<?php

use Illuminate\Support\Facades\Route;

// Public Controllers
use App\Http\Controllers\Api\V1\ClientController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\ProjectTypeController;
use App\Http\Controllers\Api\V1\EnquiryController;
use App\Http\Controllers\Api\V1\ContactController;

// Admin Controllers (Aliased to prevent naming collisions)
use App\Http\Controllers\Api\V1\Admin\AuthController;
use App\Http\Controllers\Api\V1\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Api\V1\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Api\V1\Admin\EnquiryController as AdminEnquiryController;
use App\Http\Controllers\Api\V1\Admin\ContactController as AdminContactController;

// All API routes fall under the V1 namespace
Route::prefix('v1')->group(function () {
    
    // ==========================================
    // PUBLIC ROUTES
    // ==========================================
    // Read-only resource endpoints
    Route::get('/clients', [ClientController::class, 'index']);
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/project-types', [ProjectTypeController::class, 'index']);
    
    // Action endpoints
    Route::post('/contact', [ContactController::class, 'store']);
    Route::post('/enquiries', [EnquiryController::class, 'store']);
    
    
    // ==========================================
    // ADMIN ROUTES
    // ==========================================
    Route::prefix('admin')->group(function () {
        
        // Public Admin Route
        Route::post('/login', [AuthController::class, 'login']);

        // Secured Admin Routes
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            
            // ==========================================
            // MULTIPART UPDATE FIX
            // Explicitly define POST routes to handle file uploads correctly
            // ==========================================
            Route::post('clients/{client}', [AdminClientController::class, 'update']);
            Route::post('projects/{project}', [AdminProjectController::class, 'update']);

            // Resource CRUD (Excluding default PUT/PATCH updates)
            Route::apiResource('clients', AdminClientController::class)->except(['update']);
            Route::apiResource('projects', AdminProjectController::class)->except(['update']);
            
            // Enquiries (Read & Update Status)
            Route::get('enquiries', [AdminEnquiryController::class, 'index']);
            Route::get('enquiries/{enquiry}', [AdminEnquiryController::class, 'show']);
            Route::patch('enquiries/{enquiry}/status', [AdminEnquiryController::class, 'updateStatus']);

            // Contacts (Read & Mark Read)
            Route::get('contacts', [AdminContactController::class, 'index']);
            Route::get('contacts/{contact}', [AdminContactController::class, 'show']);
            Route::patch('contacts/{contact}/read', [AdminContactController::class, 'markAsRead']);
        });
        
    });
});