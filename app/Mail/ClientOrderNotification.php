<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClientOrderNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    public $type;

    /**
     * Create a new message instance.
     * $type bisa berisi: 'requested' atau 'payment_uploaded'
     */
    public function __construct(Order $order, $type = 'requested')
    {
        $this->order = $order;
        $this->type = $type;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->type === 'payment_uploaded'
            ? 'Payment Proof Received - Order #' . $this->order->id
            : 'Project Request Confirmed - Order #' . $this->order->id;

        return new Envelope(
            subject: 'TechnoG Solutions: ' . $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            // Sesuai dengan direktori aslimu
            view: 'emails.order-notification',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
