<form method="POST" action="{{ route('jobs.apply', $listing) }}" enctype="multipart/form-data" class="mt-6 space-y-5">
    @csrf
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
    <label class="form-field">
        <span>تاريخ الميلاد</span>
        <input type="date" name="birthday" value="{{ old('birthday') }}" required>
        @error('birthday')<small>{{ $message }}</small>@enderror
    </label>
    <label class="form-field">
        <span>السيرة الذاتية</span>
        <span class="relative flex min-h-28 flex-col items-center justify-center gap-2 rounded-md border border-dashed border-alisary-green/25 bg-alisary-muted/40 px-4 py-5 text-center text-alisary-soft">
            <x-icons.remix.upload-cloud class="size-7 text-alisary-gold" />
            <input type="file" name="cv" accept=".pdf,.doc,.docx" required class="absolute inset-0 cursor-pointer opacity-0">
            <span>PDF أو DOC أو DOCX</span>
        </span>
        @error('cv')<small>{{ $message }}</small>@enderror
    </label>

    @foreach ($listing->form_fields ?? [] as $field)
        @include('website.partials.custom-field', ['field' => $field])
    @endforeach

    <button class="inline-flex w-full items-center justify-center gap-3 rounded-md bg-alisary-green px-6 py-4 font-bold text-white transition hover:bg-alisary-deep">
        إرسال الطلب
        <x-icons.remix.arrow-left class="size-5" />
    </button>
</form>
