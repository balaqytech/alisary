<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobSubmissionRequest;
use App\Http\Requests\StoreTenderSubmissionRequest;
use App\Models\JobListing;
use App\Models\TenderListing;
use App\Support\CustomFormFields;
use Illuminate\Http\RedirectResponse;

class ListingSubmissionController extends Controller
{
    public function storeJob(StoreJobSubmissionRequest $request, JobListing $jobListing): RedirectResponse
    {
        $validated = $request->validated();
        $cvPath = $request->file('cv')?->store("submissions/jobs/{$jobListing->id}/cv", 'public');

        $jobListing->submissions()->create([
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'birthday' => $validated['birthday'],
            'cv_path' => $cvPath,
            'answers' => $validated['answers'] ?? [],
            'files' => CustomFormFields::storeFiles($request, "submissions/jobs/{$jobListing->id}/files"),
        ]);

        return back()->with('status', 'تم استلام طلبكم بنجاح، وسيتواصل معكم الفريق عند الحاجة.');
    }

    public function storeTender(StoreTenderSubmissionRequest $request, TenderListing $tenderListing): RedirectResponse
    {
        $validated = $request->validated();

        $tenderListing->submissions()->create([
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'answers' => $validated['answers'] ?? [],
            'files' => CustomFormFields::storeFiles($request, "submissions/tenders/{$tenderListing->id}/files"),
        ]);

        return back()->with('status', 'تم استلام طلبكم بنجاح، وسيتواصل معكم الفريق عند الحاجة.');
    }
}
