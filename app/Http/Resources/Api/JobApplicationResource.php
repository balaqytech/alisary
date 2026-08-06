<?php

namespace App\Http\Resources\Api;

use App\Support\JobExperienceRanges;
use App\Support\ResidenceCountries;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class JobApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'reference_number' => $this->reference_number,
            'status' => $this->status?->value,
            'full_name' => $this->full_name,
            'phone' => trim("{$this->phone_country_code} {$this->phone}"),
            'email' => $this->email,
            'gender' => match ($this->gender) {
                'male' => 'ذكر',
                'female' => 'أنثى',
                default => $this->gender,
            },
            'nationality' => $this->nationality,
            'country' => ResidenceCountries::label($this->country),
            'city' => $this->city,
            'company_id' => $this->company_id,
            'company' => $this->company === null ? null : [
                'id' => $this->company->id,
                'name' => $this->company->name,
            ],
            'governorate' => $this->governorate?->value,
            'branch' => $this->branch?->value,
            'job_priority_1' => $this->firstPriorityJobTitle(),
            'track' => $this->track?->value,
            'contract_types' => $this->contract_types,
            'ready_date' => $this->ready_date?->format('Y-m-d'),
            'expected_salary' => $this->expected_salary,
            'years_experience' => JobExperienceRanges::label($this->years_experience),
            'previously_worked' => $this->previously_worked ? 'نعم' : 'لا',
            'previous_institution' => $this->previous_institution,
            'previous_role' => $this->previous_role,
            'previous_period' => $this->previous_period,
            'tools_and_ai' => $this->tools_and_ai,
            'cv_link' => $this->cvUrl(),
            'q_achievement' => $this->q_achievement,
            'q_sample_teaching' => $this->q_sample_teaching,
            'q_sample_operations' => $this->q_sample_operations,
            'q_sample_leadership' => $this->q_sample_leadership,
            'q_compelling_reason' => $this->q_compelling_reason,
            'consent_accurate' => $this->consent_accurate ? 'نعم' : 'لا',
            'consent_ai' => $this->consent_ai ? 'نعم' : 'لا',
            'consent_pool' => $this->consent_pool ? 'نعم' : 'لا',
            'internal_notes' => $this->internal_notes,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }

    private function cvUrl(): ?string
    {
        if (filled($this->cv_link)) {
            return $this->cv_link;
        }

        if (blank($this->cv_path)) {
            return null;
        }

        return Storage::disk('public')->url($this->cv_path);
    }
}
