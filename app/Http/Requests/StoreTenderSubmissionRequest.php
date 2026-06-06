<?php

namespace App\Http\Requests;

use App\Models\TenderListing;
use App\Support\CustomFormFields;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTenderSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->tenderListing()?->isAcceptingSubmissions() ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            ...CustomFormFields::validationRules(
                CustomFormFields::flattenSteps($this->tenderListing()?->form_steps ?? [])
            ),
        ];
    }

    protected function tenderListing(): ?TenderListing
    {
        $tenderListing = $this->route('tenderListing');

        return $tenderListing instanceof TenderListing ? $tenderListing : null;
    }
}
