<?php

namespace App\Http\Requests;

use App\Models\DataRightsRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDataRightsRequest extends FormRequest
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
            'request_type' => ['required', 'string', Rule::in(DataRightsRequest::REQUEST_TYPES)],
            'email' => ['required', 'email', 'max:255'],
            'details' => ['nullable', 'string', 'max:2000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'request_type' => 'نوع الطلب',
            'email' => 'البريد الإلكتروني',
            'details' => 'تفاصيل الطلب',
        ];
    }
}
