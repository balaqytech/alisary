<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobApplicationRequest;
use App\Models\JobApplication;
use Illuminate\Http\RedirectResponse;

class JobApplicationController extends Controller
{
    public function store(StoreJobApplicationRequest $request, \App\Settings\GeneralSettings $settings): RedirectResponse
    {
        $validated = $request->validated();

        $cvPath = $request->file('cv')?->store('job-applications/cv', 'public');

        $application = JobApplication::create([
            ...\Illuminate\Support\Arr::except($validated, ['cv']),
            'cv_path' => $cvPath,
            'previously_worked' => (bool) ($validated['previously_worked'] ?? false),
            'consent_pool' => (bool) ($validated['consent_pool'] ?? false),
            'consent_transfer' => (bool) ($validated['consent_transfer'] ?? false),
        ]);

        $emails = $settings->jobSubmissionRecipientEmails();
        if (! empty($emails)) {
            \Illuminate\Support\Facades\Mail::to($emails)->queue(new \App\Mail\JobSubmissionReceived($application));
        }

        return back()
            ->withFragment('apply-form')
            ->with('application_success', true);
    }
}
