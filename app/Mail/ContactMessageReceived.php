<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessageReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $message) {}

    public function envelope(): Envelope
    {
        $name = str_replace(["\r", "\n"], '', $this->message->name);

        return new Envelope(
            to: [new Address('jacquesmaud@referencemedicosarl.com')],
            replyTo: [new Address($this->message->email, $name)],
            subject: 'Message du site — '.$name,
        );
    }

    public function content(): Content
    {
        return new Content(
            text: 'mail.contact-message',
        );
    }
}
