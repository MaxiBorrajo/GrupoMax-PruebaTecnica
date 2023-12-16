<?php

namespace App\Listeners;

use App\Events\ResetPasswordEvent;
use App\Models\PasswordResetToken;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ResetPasswordListener
{

    public function __construct()
    {

    }

    public function handle(ResetPasswordEvent $event): void
    {
        PasswordResetToken::where('email', $event->email)->delete();
    }
}
