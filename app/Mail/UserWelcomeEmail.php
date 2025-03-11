<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class UserWelcomeEmail extends Mailable
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('emails.user_welcome')
            ->subject('Welcome to ' . env('APP_NAME'))
            ->with([
                'user' => $this->user,
            ]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to ' . env('APP_NAME'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.user_welcome',
        );
    }



    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
