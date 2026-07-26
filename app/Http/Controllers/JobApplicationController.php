<?php

namespace App\Http\Controllers;

use App\Enums\ListingLocation;
use App\Http\Requests\StoreJobApplicationRequest;
use App\Mail\DuplicateJobApplicationDetected;
use App\Mail\JobSubmissionReceived;
use App\Models\JobApplication;
use App\Models\JobListing;
use App\Settings\GeneralSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class JobApplicationController extends Controller
{
    private const MIN_FILL_SECONDS = 3;

    public function store(StoreJobApplicationRequest $request, GeneralSettings $settings): RedirectResponse
    {
        $validated = Arr::except($request->validated(), ['website', 'form_rendered_at']);

        if ($this->submittedTooFast($request)) {
            // Silently pretend success so bots don't learn their submission was rejected.
            return back()->withFragment('apply-form')->with('application_success', true);
        }

        $jobListing = JobListing::query()
            ->where('job_code', $validated['job_priority_1'] ?? null)
            ->with('jobFamily')
            ->first();

        // The governorate select is only shown (and submitted) when a job
        // spans more than one governorate. Otherwise fall back to deriving
        // it from the chosen branch, or the job listing's single location.
        $locationValue = $validated['branch'] ?? $jobListing?->location?->value;
        $governorate = ($validated['governorate'] ?? null)
            ?: ListingLocation::tryFrom($locationValue ?? '')?->governorate()?->value;

        $application = JobApplication::query()->firstOrCreate([
            'submission_token' => $validated['submission_token'],
        ], [
            ...Arr::except($validated, ['submission_token']),
            'form_version' => 'v2',
            'governorate' => $governorate,
            'track' => $jobListing?->jobFamily?->track?->value,
            'previously_worked' => (bool) ($validated['previously_worked'] ?? false),
            'consent_pool' => (bool) ($validated['consent_pool'] ?? false),
        ]);

        if ($application->wasRecentlyCreated) {
            $this->notifyOnPossibleDuplicate($application, $settings);

            $emails = $settings->jobSubmissionRecipientEmails();
            if (! empty($emails)) {
                Mail::to($emails)->queue(new JobSubmissionReceived($application));
            }
        }

        return back()
            ->withFragment('apply-form')
            ->with('application_success', true)
            ->with('application_reference_number', $application->reference_number)
            ->with('application_submission_token', $application->submission_token);
    }

    private function submittedTooFast(StoreJobApplicationRequest $request): bool
    {
        $renderedAt = $request->integer('form_rendered_at');

        if ($renderedAt <= 0) {
            return false;
        }

        return (time() - $renderedAt) < self::MIN_FILL_SECONDS;
    }

    private function notifyOnPossibleDuplicate(JobApplication $application, GeneralSettings $settings): void
    {
        $duplicate = JobApplication::query()
            ->where('id', '!=', $application->id)
            ->where(function ($query) use ($application): void {
                $query->where('email', $application->email)
                    ->orWhere(function ($query) use ($application): void {
                        $query->where('phone_country_code', $application->phone_country_code)
                            ->where('phone', $application->phone);
                    });
            })
            ->first();

        if ($duplicate === null) {
            return;
        }

        $emails = $settings->jobSubmissionRecipientEmails();
        if (empty($emails)) {
            return;
        }

        Mail::to($emails)->queue(
            new DuplicateJobApplicationDetected($application, $duplicate)
        );
    }
}
