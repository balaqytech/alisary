<?php

namespace App\Mail;

use App\Filament\Resources\JobApplications\JobApplicationResource;
use App\Filament\Resources\Submissions\SubmissionResource;
use App\Models\JobApplication;
use App\Models\JobListing;
use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobSubmissionReceived extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public JobApplication|Submission $application;

    public ?JobListing $jobListing = null;

    public ?Submission $submission = null;

    /**
     * Create a new message instance.
     */
    public function __construct(JobApplication|JobListing $application, ?Submission $submission = null)
    {
        if ($application instanceof JobApplication) {
            $this->application = $application;
        } else {
            $this->jobListing = $application;
            $this->submission = $submission ?? throw new \InvalidArgumentException('A submission is required for a job listing notification.');
            $this->application = $this->submission;
        }

        $this->afterCommit();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $jobTitle = $this->jobListing === null ? '' : "{$this->jobListing->title} — ";
        $reference = $this->application instanceof JobApplication ? " ({$this->application->reference_number})" : '';

        return new Envelope(
            subject: "طلب توظيف جديد: {$jobTitle}{$this->application->full_name}{$reference}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $adminUrl = $this->application instanceof JobApplication
            ? JobApplicationResource::getUrl('view', ['record' => $this->application])
            : SubmissionResource::getUrl('edit', ['record' => $this->application]);

        return new Content(
            markdown: 'emails.submissions.job-submission-received',
            with: [
                'adminUrl' => $adminUrl,
            ],
        );
    }
}
