@php
    $customSections = collect(\App\Support\CustomFormFields::sections($listing->form_fields ?? []))->values();
    $basicCustomSection = null;

    if (($customSections->first()['title'] ?? null) === 'البيانات الأساسية') {
        $basicCustomSection = $customSections->shift();
    }

    $stepsCount = $customSections->count() + 1;
@endphp

<form method="POST" action="{{ route('jobs.apply', $listing) }}" enctype="multipart/form-data" class="job-application-form" data-form-wizard>
    @csrf

    <div class="application-progress" aria-label="خطوات نموذج التقديم">
        @for ($step = 1; $step <= $stepsCount; $step++)
            <span data-wizard-indicator class="wizard-indicator {{ $step === 1 ? 'is-active' : '' }}">{{ \App\Support\NumberLocalizer::eastern($step) }}</span>
        @endfor
    </div>

    <section data-wizard-step class="application-step">
        <div class="application-step-head">
            <span class="application-step-kicker">{{ \App\Support\NumberLocalizer::eastern(1) }}</span>
            <div>
                <h3>البيانات الأساسية</h3>
                <p>{{ $basicCustomSection['description'] ?? 'لنتمكّن من التواصل معك وتحديد الوظيفة المناسبة.' }}</p>
            </div>
        </div>

        <div class="application-field-grid">
            <label class="form-field">
                <span>الاسم الكامل <b>*</b></span>
                <input name="full_name" value="{{ old('full_name') }}" required>
                @error('full_name')<small>{{ $message }}</small>@enderror
            </label>
            <label class="form-field">
                <span>رقم الهاتف <b>*</b></span>
                <input name="phone" value="{{ old('phone') }}" required>
                @error('phone')<small>{{ $message }}</small>@enderror
            </label>
            <label class="form-field">
                <span>البريد الإلكتروني <b>*</b></span>
                <input type="email" name="email" value="{{ old('email') }}" required>
                @error('email')<small>{{ $message }}</small>@enderror
            </label>
            <label class="form-field">
                <span>تاريخ الميلاد <b>*</b></span>
                <input type="date" name="birthday" value="{{ old('birthday') }}" required>
                @error('birthday')<small>{{ $message }}</small>@enderror
            </label>
        </div>

        @if (count($basicCustomSection['fields'] ?? []) > 0)
            <div class="application-field-grid">
                @foreach ($basicCustomSection['fields'] as $field)
                    @include('website.partials.custom-field', ['field' => $field])
                @endforeach
            </div>
        @endif

        <label class="form-field">
            <span>السيرة الذاتية <b>*</b></span>
            <span class="application-upload">
                <x-icons.remix.upload-cloud class="size-8 text-alisary-gold" />
                <input type="file" name="cv" accept=".pdf,.doc,.docx" required>
                <span>PDF أو DOC أو DOCX</span>
            </span>
            @error('cv')<small>{{ $message }}</small>@enderror
        </label>
    </section>

    @foreach ($customSections as $index => $section)
        <section data-wizard-step class="application-step hidden">
            <div class="application-step-head">
                <span class="application-step-kicker">{{ \App\Support\NumberLocalizer::eastern($index + 2) }}</span>
                <div>
                    <h3>{{ $section['title'] }}</h3>
                    @if (filled($section['description'] ?? null))
                        <p>{{ $section['description'] }}</p>
                    @endif
                </div>
            </div>

            <div class="application-field-grid">
                @foreach ($section['fields'] ?? [] as $field)
                    @include('website.partials.custom-field', ['field' => $field])
                @endforeach
            </div>
        </section>
    @endforeach

    <div class="application-actions">
        <button type="button" data-wizard-prev class="application-nav-button">
            <x-icons.remix.arrow-right class="size-5" />
            السابق
        </button>
        <button type="button" data-wizard-next class="application-submit-button">
            التالي
            <x-icons.remix.arrow-left class="size-5" />
        </button>
        <button data-wizard-submit class="application-submit-button hidden">
            إرسال الطلب
            <x-icons.remix.check class="size-5" />
        </button>
    </div>
</form>
