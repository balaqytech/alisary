<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobApplicationRequest;
use App\Models\JobApplication;
use Illuminate\Http\RedirectResponse;

class JobApplicationController extends Controller
{
    public function store(StoreJobApplicationRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $cvPath = $request->file('cv')?->store('job-applications/cv', 'public');

        JobApplication::create([
            ...\Illuminate\Support\Arr::except($validated, ['cv']),
            'cv_path' => $cvPath,
            'previously_worked' => (bool) ($validated['previously_worked'] ?? false),
            'consent_pool' => (bool) ($validated['consent_pool'] ?? false),
            'consent_transfer' => (bool) ($validated['consent_transfer'] ?? false),
        ]);

        return back()
            ->withFragment('apply-form')
            ->with('application_success', true);
    }
}
