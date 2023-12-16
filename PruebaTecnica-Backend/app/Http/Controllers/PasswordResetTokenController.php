<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\PasswordResetTokenRequest;
use App\Http\Services\PasswordResetTokenService;
use Exception;

class PasswordResetTokenController extends Controller
{

    protected $passwordResetTokenService;

    public function __construct(PasswordResetTokenService $passwordResetTokenService)
    {
        $this->passwordResetTokenService = $passwordResetTokenService;
    }


    public function forgotPassword(ForgotPasswordRequest $request)
    {
            $this->passwordResetTokenService->createPasswordResetToken($request);
            return response()->json(['message' => 'Email sent. Go to your email account to change your password'], 200);

    }

    public function resetPassword(PasswordResetTokenRequest $request)
    {
            $this->passwordResetTokenService->resetPassword($request);

            return response()->json(['message' => 'Password changed successfully'], 200);

    }
}
