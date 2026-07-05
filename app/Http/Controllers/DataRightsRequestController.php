<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDataRightsRequest;
use App\Mail\DataRightsRequestReceived;
use App\Models\DataRightsRequest;
use App\Settings\GeneralSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class DataRightsRequestController extends Controller
{
    public function store(StoreDataRightsRequest $request, GeneralSettings $settings): RedirectResponse
    {
        $validated = $request->validated();

        $rightsRequest = DataRightsRequest::create([
            ...$validated,
            'submitted_from_url' => url()->previous(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $emails = $settings->privacyRightsRecipientEmails();

        if (! empty($emails)) {
            Mail::to($emails)->queue(new DataRightsRequestReceived($rightsRequest));
        }

        return back()
            ->withFragment('rights')
            ->with('data_rights_success', true)
            ->with('data_rights_reference', $rightsRequest->reference_number);
    }
}
