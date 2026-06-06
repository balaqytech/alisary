<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreListingSubmissionRequest;
use App\Models\Listing;
use Illuminate\Http\RedirectResponse;

class ListingSubmissionController extends Controller
{
    public function store(StoreListingSubmissionRequest $request, Listing $listing): RedirectResponse
    {
        $validated = $request->validated();
        $storedFiles = [];

        foreach ($request->file('files', []) as $key => $file) {
            $storedFiles[$key] = $file->store("submissions/{$listing->id}", 'public');
        }

        $listing->submissions()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'answers' => $validated['answers'] ?? [],
            'files' => $storedFiles,
        ]);

        return back()->with('status', 'تم استلام طلبكم بنجاح، وسيتواصل معكم الفريق عند الحاجة.');
    }
}
