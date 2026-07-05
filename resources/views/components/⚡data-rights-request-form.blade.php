<?php

use App\Mail\DataRightsRequestReceived;
use App\Models\DataRightsRequest;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Livewire\Component;

new class extends Component
{
    public string $request_type = '';

    public string $email = '';

    public string $details = '';

    public ?string $successReference = null;

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
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
    protected function validationAttributes(): array
    {
        return [
            'request_type' => 'نوع الطلب',
            'email' => 'البريد الإلكتروني',
            'details' => 'تفاصيل الطلب',
        ];
    }

    public function submit(): void
    {
        $validated = $this->validate();

        $rightsRequest = DataRightsRequest::create([
            ...$validated,
            'submitted_from_url' => request()->headers->get('referer') ?: url()->current(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $emails = app(GeneralSettings::class)->privacyRightsRecipientEmails();

        if (! empty($emails)) {
            Mail::to($emails)->queue(new DataRightsRequestReceived($rightsRequest));
        }

        $this->reset('request_type', 'email', 'details');
        $this->successReference = $rightsRequest->reference_number;
    }
};
?>

<div>
    @if ($successReference)
        <div class="rounded-xl border border-alisary-green/20 bg-alisary-green/5 p-4 text-alisary-deep">
            <div class="font-display text-lg">تم تسجيل طلبك.</div>
            <p class="mt-1 text-sm leading-loose text-alisary-soft">
                الرقم المرجعي:
                <b class="text-alisary-deep">{{ $successReference }}</b>
            </p>
        </div>
    @endif

    <form wire:submit="submit" class="mt-6 border-t border-dashed border-alisary-green/20 pt-5">
        <div class="flex flex-col gap-1.5">
            <label for="rights-request-type" class="text-sm font-medium text-alisary-deep">نوع الطلب <span class="text-red-600">*</span></label>
            <select id="rights-request-type" wire:model="request_type" required
                class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                <option value="">— اختر الحقّ —</option>
                @foreach (DataRightsRequest::REQUEST_TYPES as $requestType)
                    <option value="{{ $requestType }}">{{ $requestType }}</option>
                @endforeach
            </select>
            @error('request_type')
                <div class="text-xs text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <div class="mt-4 flex flex-col gap-1.5">
            <label for="rights-email" class="text-sm font-medium text-alisary-deep">بريدك للتواصل <span class="text-red-600">*</span></label>
            <input id="rights-email" wire:model="email" type="email" required placeholder="name@example.com" dir="ltr"
                class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 text-left font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
            @error('email')
                <div class="text-xs text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <div class="mt-4 flex flex-col gap-1.5">
            <label for="rights-details" class="text-sm font-medium text-alisary-deep">تفاصيل الطلب (اختياري)</label>
            <textarea id="rights-details" wire:model="details" rows="3" maxlength="2000"
                class="min-h-[92px] w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20"></textarea>
            @error('details')
                <div class="text-xs text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit"
            class="mt-5 inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-xl bg-alisary-green px-5 py-3 font-display text-lg text-white transition hover:bg-alisary-deep disabled:cursor-wait disabled:opacity-70"
            wire:loading.attr="disabled">
            <span wire:loading.remove>إرسال طلب ممارسة الحقّ</span>
            <span wire:loading>جارٍ الإرسال...</span>
        </button>
    </form>
</div>
