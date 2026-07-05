<?php

namespace App\Mail;

use App\Filament\Resources\DataRightsRequests\DataRightsRequestResource;
use App\Models\DataRightsRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DataRightsRequestReceived extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public DataRightsRequest $rightsRequest,
    ) {
        $this->afterCommit();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "طلب ممارسة حق بيانات شخصية: {$this->rightsRequest->reference_number}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.privacy.data-rights-request-received',
            with: [
                'adminUrl' => DataRightsRequestResource::getUrl('view', ['record' => $this->rightsRequest]),
            ],
        );
    }
}
