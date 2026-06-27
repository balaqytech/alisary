<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

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
            'job_priority_1' => ['required', 'string', 'max:255'],
            'job_priority_2' => ['nullable', 'string', 'max:255'],
            'job_priority_3' => ['nullable', 'string', 'max:255'],
            'contract_types' => ['required', 'array', 'min:1'],
            'contract_types.*' => ['string'],
            'ready_date' => ['nullable', 'date'],
            'expected_salary' => ['required', 'string', 'max:255'],

            // Section 3: Experience & Tools
            'years_experience' => ['nullable', 'integer', 'min:0', 'max:60'],
            'previously_worked' => ['nullable', 'boolean'],
            'previously_worked_where' => ['nullable', 'string', 'max:500'],
            'tools_and_ai' => ['nullable', 'string'],
            'cv_link' => ['nullable', 'url', 'max:500'],
            'cv' => ['nullable', File::types(['pdf', 'doc', 'docx'])->max(3072)],

            // Section 4: Competency
            'q_automate' => ['nullable', 'string'],
            'q_learn' => ['nullable', 'string'],
            'q_own' => ['nullable', 'string'],

            // Section 5: Situational
            'q_brand' => ['nullable', 'string'],
            'q_ethics' => ['nullable', 'string'],
            'q_mission' => ['nullable', 'string'],

            // Section 6: Future
            'future_aspirations' => ['nullable', 'string'],
            'q_build' => ['nullable', 'string'],
            'extra_notes' => ['nullable', 'string'],

            // Section 7: Consents
            'consent_accurate' => ['required', 'accepted'],
            'consent_ai' => ['required', 'accepted'],
            'consent_pool' => ['nullable', 'boolean'],
            'consent_transfer' => ['nullable', 'boolean'],
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
            'job_priority_1' => 'أولوية الوظيفة الأولى',
            'contract_types' => 'نمط التعاقد',
            'expected_salary' => 'الراتب الشهري المتوقع',
            'consent_accurate' => 'إقرار صحة البيانات',
            'consent_ai' => 'موافقة المعالجة بالذكاء الاصطناعي',
        ];
    }
}
