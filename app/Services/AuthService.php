<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AuthService
{
    /**
     * Authenticate an admin user and generate a token.
     */
    public function authenticateAdmin(array $credentials): array
    {
        $user = User::where('email', $credentials['email'])->first();

        // 1. Check if user exists and password is correct
        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid login credentials.'],
            ]);
        }

        // 2. Allow specific roles to access the admin panel
        $allowedRoles = ['superadmin', 'admin', 'manager', 'editor'];
        
        if (! in_array($user->role, $allowedRoles)) {
            throw new AccessDeniedHttpException('Unauthorized access.');
        }

        // 3. Generate token
        $token = $user->createToken('admin-dashboard-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * Revoke the user's current token.
     */
    public function logoutAdmin(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}