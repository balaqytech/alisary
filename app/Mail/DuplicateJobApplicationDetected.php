<?php

namespace App\Mail;

use App\Filament\Resources\JobApplications\JobApplicationResource;
use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DuplicateJobApplicationDetected extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public JobApplication $application,
        public JobApplication $duplicateOf,
    ) {
        $this->afterCommit();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "تنبيه: تقديم مكرر محتمل — {$this->application->full_name} ({$this->application->reference_number})",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.submissions.duplicate-job-application-detected',
            with: [
                'newApplicationUrl' => JobApplicationResource::getUrl('view', ['record' => $this->application]),
                'previousApplicationUrl' => JobApplicationResource::getUrl('view', ['record' => $this->duplicateOf]),
            ],
        );
    }
}
