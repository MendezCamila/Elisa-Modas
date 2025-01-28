<?php
namespace App\Mail;

use App\Models\OrdenCompra;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnviarOrdenCompraMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ordenCompra;

    public function __construct(OrdenCompra $ordenCompra)
    {
        $this->ordenCompra = $ordenCompra;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nueva Orden de Compra',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'admin.emails.orden-compra',
            with: [
                'ordenCompra' => $this->ordenCompra,
            ],
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
