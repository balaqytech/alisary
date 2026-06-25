<?php

namespace App\Mail;

use App\Filament\Resources\Submissions\SubmissionResource;
use App\Models\Submission;
use App\Models\TenderListing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TenderSubmissionReceived extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public TenderListing $tenderListing,
        public Submission $submission,
    ) {
        $this->afterCommit();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "طلب تقديم جديد على مناقصة: {$this->tenderListing->title}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.submissions.tender-submission-received',
            with: [
                'adminUrl' => SubmissionResource::getUrl('edit', ['record' => $this->submission]),
            ],
        );
    }
}
