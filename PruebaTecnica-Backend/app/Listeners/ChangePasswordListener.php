<?php

namespace App\Listeners;

use App\Events\ChangePasswordEvent;
use App\Models\PasswordResetToken;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ChangePasswordListener
{
    public function __construct()
    {
    }
    public function handle(ChangePasswordEvent $event): void
    {
        DB::table('users')->where('email', $event->email)->update(['password' => Hash::make($event->password)]);

        PasswordResetToken::where('token', $event->token)->delete();
    }
}
