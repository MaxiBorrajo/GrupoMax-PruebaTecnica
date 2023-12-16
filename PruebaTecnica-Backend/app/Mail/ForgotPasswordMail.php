<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public $token)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Password Reset Requested',
            from: new Address(env('MAIL_FROM_ADDRESS', 'no-reply@example.com'), env('MAIL_FROM_NAME', 'example.com'))
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ForgotPasswordMail',

        );
    }

    public function attachments(): array
    {
        return [];
    }
}
