<?php

namespace App\Mail;

use App\Models\MeetingRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MeetingRequestAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public MeetingRequest $meeting) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🚀 New Lead: Permintaan Meeting - ' . $this->meeting->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.meeting-admin',
        );
    }
}
