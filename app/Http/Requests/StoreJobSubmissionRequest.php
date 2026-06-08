<?php

namespace App\Http\Requests;

use App\Models\JobListing;
use App\Support\CustomFormFields;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StoreJobSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->jobListing()?->isAcceptingSubmissions() ?? false;
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
            'birthday' => ['required', 'date', 'before:today'],
            'cv' => ['required', File::types(['pdf', 'doc', 'docx'])->max(5120)],
            ...CustomFormFields::validationRules(
                CustomFormFields::flattenFields($this->jobListing()?->form_fields ?? [])
            ),
        ];
    }

    protected function jobListing(): ?JobListing
    {
        $jobListing = $this->route('jobListing');

        return $jobListing instanceof JobListing ? $jobListing : null;
    }
}
