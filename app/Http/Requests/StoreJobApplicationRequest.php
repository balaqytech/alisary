<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreJobApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * Honeypot + submitted-at fields are handled separately, before this
     * request's rules run (see StoreJobApplicationRequest::withValidator
     * usage is intentionally avoided here to keep spam checks silent).
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Section 1: Basic Info
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'nationality' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],

            // Section 2: Job & Institution
            'company_id' => ['required', 'exists:companies,id'],
            'governorate' => ['nullable', 'string', 'max:100'],
            'branch' => ['nullable', 'string', 'max:100'],
            'job_priority_1' => ['required', 'string', 'max:255'],
            'contract_types' => ['required', 'array', 'min:1'],
            'contract_types.*' => ['string'],
            'ready_date' => ['nullable', 'date'],
            'expected_salary' => ['required', 'string', 'max:255'],

            // Section 3: Experience & Tools
            'years_experience' => ['nullable', 'integer', 'min:0', 'max:60'],
            'previously_worked' => ['nullable', 'boolean'],
            'previous_institution' => ['nullable', 'string', 'max:255'],
            'previous_role' => ['nullable', 'string', 'max:255'],
            'previous_period' => ['nullable', 'string', 'max:255'],
            'tools_and_ai' => ['nullable', 'string'],
            'cv_link' => ['nullable', 'url', 'max:500'],

            // Section 4: Pivotal questions
            'q_achievement' => ['required', 'string', 'max:1200'],
            // Only one of the three is actually enabled client-side, based on the
            // applicant's job track — the others are disabled and never submitted.
            // Not marked required here since a track without a matching question
            // (currently "support") must still be able to submit.
            'q_sample_teaching' => ['nullable', 'string', 'max:1200'],
            'q_sample_operations' => ['nullable', 'string', 'max:1200'],
            'q_sample_leadership' => ['nullable', 'string', 'max:1200'],

            // Section 5: Consents
            'consent_accurate' => ['required', 'accepted'],
            'consent_ai' => ['required', 'accepted'],
            'consent_pool' => ['nullable', 'boolean'],

            // Anti-spam: honeypot field must stay empty, must not be filled too fast.
            'website' => ['prohibited'],
            'form_rendered_at' => ['nullable', 'integer'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'full_name' => 'الاسم الكامل',
            'phone' => 'رقم الهاتف',
            'email' => 'البريد الإلكتروني',
            'company_id' => 'المؤسسة',
            'branch' => 'الفرع',
            'job_priority_1' => 'أولوية الوظيفة الأولى',
            'contract_types' => 'نمط التعاقد',
            'expected_salary' => 'الراتب الشهري المتوقع',
            'consent_accurate' => 'إقرار صحة البيانات',
            'consent_ai' => 'موافقة المعالجة بالذكاء الاصطناعي',
        ];
    }
}
