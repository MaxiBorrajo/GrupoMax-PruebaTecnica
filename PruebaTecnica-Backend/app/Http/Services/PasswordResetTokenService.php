<?php
namespace App\Http\Services;

use App\Events\ChangePasswordEvent;
use App\Events\ResetPasswordEvent;
use App\Exceptions\TokenExpiredException;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\PasswordResetTokenRequest;
use App\Models\PasswordResetToken;
use Illuminate\Support\Carbon;

class PasswordResetTokenService
{
    function getExpirationDate()
    {
        $now = Carbon::now();
        $futureDate = $now->addMinutes(10);
        return $futureDate;
    }

    function createPasswordResetToken(ForgotPasswordRequest $request)
    {
        ResetPasswordEvent::dispatch($request->email);

        //Posee observer que se encarga de enviar un mail
        PasswordResetToken::create([
            'email' => $request->email,
            'token' => uniqid(),
            'expiration' => $this->getExpirationDate(),
            'created_at' => Carbon::now()
        ]);
    }

    function validateTokenExpiration($expiration)
    {
        if (Carbon::now() > $expiration) {
            throw new TokenExpiredException();
        }
    }

    function resetPassword(PasswordResetTokenRequest $request)
    {
        $foundResetToken = PasswordResetToken::where('token', $request->token)->first();

        $this->validateTokenExpiration($foundResetToken->expiration);

        ChangePasswordEvent::dispatch($foundResetToken->email, $request->password, $foundResetToken->token);
    }

}