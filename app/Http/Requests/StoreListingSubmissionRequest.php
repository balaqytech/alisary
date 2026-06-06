<?php

namespace App\Http\Requests;

use App\Enums\CustomFieldType;
use App\Models\Listing;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StoreListingSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->listing()?->isAcceptingSubmissions() ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'answers' => ['array'],
            'files' => ['array'],
        ];

        foreach ($this->listing()?->form_fields ?? [] as $field) {
            $key = $field['key'] ?? null;
            $type = $field['type'] ?? null;

            if (! is_string($key) || ! is_string($type)) {
                continue;
            }

            $target = $type === CustomFieldType::File->value ? "files.{$key}" : "answers.{$key}";
            $fieldRules = ($field['required'] ?? false) ? ['required'] : ['nullable'];

            $rules[$target] = [
                ...$fieldRules,
                ...$this->rulesForType($type, $field),
            ];
        }

        return $rules;
    }

    /**
     * @param  array<string, mixed>  $field
     * @return array<int, mixed>
     */
    protected function rulesForType(string $type, array $field): array
    {
        return match ($type) {
            CustomFieldType::Email->value => ['email', 'max:255'],
            CustomFieldType::Phone->value => ['string', 'max:50'],
            CustomFieldType::Number->value => ['numeric'],
            CustomFieldType::Date->value => ['date'],
            CustomFieldType::Textarea->value => ['string', 'max:5000'],
            CustomFieldType::Select->value => [
                'string',
                Rule::in(collect($field['options'] ?? [])->pluck('value')->filter()->values()->all()),
            ],
            CustomFieldType::Checkbox->value => ['accepted'],
            CustomFieldType::File->value => [
                File::types($field['accepted_file_types'] ?? ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'])
                    ->max((int) ($field['max_file_size_kb'] ?? 5120)),
            ],
            default => ['string', 'max:255'],
        };
    }

    protected function listing(): ?Listing
    {
        $listing = $this->route('listing');

        return $listing instanceof Listing ? $listing : null;
    }
}
