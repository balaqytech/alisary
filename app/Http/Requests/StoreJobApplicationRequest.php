<?php

namespace App\Http\Requests;

use App\Enums\JobTrack;
use App\Models\JobListing;
use App\Support\CountryDialCodes;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;

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
        $jobTrack = JobListing::query()
            ->where('job_code', $this->string('job_priority_1')->toString())
            ->with('jobFamily')
            ->first()
            ?->jobFamily
            ?->track;

        return [
            // Section 1: Basic Info
            'full_name' => ['required', 'string', 'max:255'],
            'phone_country_code' => ['required', Rule::in(CountryDialCodes::allowedCodes())],
            'phone' => ['required', 'string', 'regex:/^[0-9]{6,15}$/'],
            'email' => [
                'required',
                'email:rfc',
                'max:255',
                Rule::unique('job_applications', 'email')
                    ->where(fn($query) => $query->where('job_priority_1', $this->input('job_priority_1'))),
            ],
            'gender' => ['required', Rule::in(['male', 'female'])],
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
            'expected_salary' => ['required', 'numeric', 'min:0', 'max:999999999'],

            // Section 3: Experience & Tools
            'years_experience' => ['nullable', 'integer', 'min:0', 'max:60'],
            'previously_worked' => ['nullable', 'boolean'],
            'previously_worked_where' => ['nullable', 'string'],
            'previous_institution' => ['nullable', 'string', 'max:255'],
            'previous_role' => ['nullable', 'string', 'max:255'],
            'previous_period' => ['nullable', 'string', 'max:255'],
            'tools_and_ai' => ['nullable', 'string'],
            'cv_link' => ['nullable', 'url', 'max:500'],

            // Section 4: Pivotal questions
            'q_achievement' => ['required', 'string', 'max:1200'],
            'q_sample_teaching' => [Rule::requiredIf($jobTrack === JobTrack::Teach), 'nullable', 'string', 'max:1200'],
            'q_sample_operations' => [Rule::requiredIf($jobTrack === JobTrack::Ops), 'nullable', 'string', 'max:1200'],
            'q_sample_leadership' => [Rule::requiredIf($jobTrack === JobTrack::Lead), 'nullable', 'string', 'max:1200'],
            'q_compelling_reason' => ['required', 'string', 'max:1200'],

            // Section 5: Consents
            'consent_accurate' => ['required', 'accepted'],
            'consent_ai' => ['required', 'accepted'],
            'consent_pool' => ['nullable', 'boolean'],

            // Anti-spam: honeypot field must stay empty, must not be filled too fast.
            'website' => ['prohibited'],
            'form_rendered_at' => ['nullable', 'integer'],
            'submission_token' => ['required', 'uuid'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $phone = preg_replace('/[\s\-().]+/', '', $this->string('phone')->toString());

        $this->merge([
            'phone' => $phone,
            'phone_country_code' => $this->input('phone_country_code', CountryDialCodes::DEFAULT),
            'submission_token' => $this->input('submission_token', (string) Str::uuid()),
        ]);
    }

    /**
     * On failure, redirect back to the form's anchor instead of the page top,
     * so the applicant actually sees their errors and old input.
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            back()
                ->withFragment('apply-form')
                ->withErrors($validator)
                ->withInput()
        );
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.unique' => 'لقد سبق أن تقدّمت بطلبٍ لهذه الوظيفة بهذا البريد الإلكتروني.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'full_name' => 'الاسم الكامل',
            'phone_country_code' => 'مفتاح الدولة',
            'phone' => 'رقم الهاتف',
            'email' => 'البريد الإلكتروني',
            'gender' => 'الجنس',
            'company_id' => 'المؤسسة',
            'branch' => 'الفرع',
            'job_priority_1' => 'أولوية الوظيفة الأولى',
            'contract_types' => 'نمط التعاقد',
            'expected_salary' => 'الراتب الشهري المتوقع',
            'years_experience' => 'سنوات الخبرة في مجال الوظيفة',
            'q_achievement' => 'سؤال الإنجاز',
            'q_sample_teaching' => 'سؤال عينة العمل لمسار التدريس',
            'q_sample_operations' => 'سؤال عينة العمل لمسار التنسيق والعمليات',
            'q_sample_leadership' => 'سؤال عينة العمل لمسار القيادة',
            'q_compelling_reason' => 'سبب اختيارك من بين المتقدمين',
            'consent_accurate' => 'إقرار صحة البيانات',
            'consent_ai' => 'موافقة المعالجة بالذكاء الاصطناعي',
        ];
    }
}
