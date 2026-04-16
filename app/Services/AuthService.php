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

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid login credentials.'],
            ]);
        }

        if ($user->role !== 'admin') {
            throw new AccessDeniedHttpException('Unauthorized access.');
        }

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