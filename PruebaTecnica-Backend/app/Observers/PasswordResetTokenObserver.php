<?php

namespace App\Observers;

use App\Mail\ForgotPasswordMail;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Mail;

class PasswordResetTokenObserver
{
    /**
     * Handle the PasswordResetToken "created" event.
     */
    public function created(PasswordResetToken $passwordResetToken): void
    {
        Mail::to($passwordResetToken->email)->send(new ForgotPasswordMail($passwordResetToken->token));
    }

    /**
     * Handle the PasswordResetToken "updated" event.
     */
    public function updated(PasswordResetToken $passwordResetToken): void
    {
        //
    }

    /**
     * Handle the PasswordResetToken "deleted" event.
     */
    public function deleted(PasswordResetToken $passwordResetToken): void
    {
        //
    }

    /**
     * Handle the PasswordResetToken "restored" event.
     */
    public function restored(PasswordResetToken $passwordResetToken): void
    {
        //
    }

    /**
     * Handle the PasswordResetToken "force deleted" event.
     */
    public function forceDeleted(PasswordResetToken $passwordResetToken): void
    {
        //
    }
}
