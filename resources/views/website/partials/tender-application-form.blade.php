@php
    $steps = collect($listing->form_steps ?? [])->filter(fn ($step) => filled($step['title'] ?? null))->values();
@endphp

<form method="POST" action="{{ route('tenders.apply', $listing) }}" enctype="multipart/form-data" class="mt-6" data-form-wizard>
    @csrf

    <div class="mb-6 flex flex-wrap gap-2">
        <span data-wizard-indicator class="wizard-indicator is-active">1</span>
        @foreach ($steps as $index => $step)
            <span data-wizard-indicator class="wizard-indicator">{{ $index + 2 }}</span>
        @endforeach
    </div>

    <section data-wizard-step class="space-y-5">
        <h3 class="text-xl font-bold text-alisary-green">بيانات التواصل</h3>
        <label class="form-field">
            <span>الاسم الكامل</span>
            <input name="full_name" value="{{ old('full_name') }}" required>
            @error('full_name')<small>{{ $message }}</small>@enderror
        </label>
        <label class="form-field">
            <span>رقم الهاتف</span>
            <input name="phone" value="{{ old('phone') }}" required>
            @error('phone')<small>{{ $message }}</small>@enderror
        </label>
        <label class="form-field">
            <span>البريد الإلكتروني</span>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email')<small>{{ $message }}</small>@enderror
        </label>
    </section>

    @foreach ($steps as $step)
        <section data-wizard-step class="hidden space-y-5">
            <div>
                <h3 class="text-xl font-bold text-alisary-green">{{ $step['title'] }}</h3>
                @if (filled($step['description'] ?? null))
                    <p class="mt-2 text-sm leading-loose text-alisary-soft">{{ $step['description'] }}</p>
                @endif
            </div>
            @foreach ($step['fields'] ?? [] as $field)
                @include('website.partials.custom-field', ['field' => $field])
            @endforeach
        </section>
    @endforeach

    <div class="mt-7 flex items-center justify-between gap-3">
        <button type="button" data-wizard-prev class="inline-flex items-center gap-2 rounded-md border border-alisary-green/20 px-5 py-3 font-bold text-alisary-green disabled:cursor-not-allowed disabled:opacity-40">
            <x-icons.remix.arrow-right class="size-5" />
            السابق
        </button>
        <button type="button" data-wizard-next class="inline-flex items-center gap-2 rounded-md bg-alisary-green px-5 py-3 font-bold text-white">
            التالي
            <x-icons.remix.arrow-left class="size-5" />
        </button>
        <button data-wizard-submit class="hidden items-center gap-2 rounded-md bg-alisary-green px-5 py-3 font-bold text-white">
            إرسال الطلب
            <x-icons.remix.check class="size-5" />
        </button>
    </div>
</form>
