<form method="POST" action="{{ route($kind === \App\Enums\ListingKind::Job ? 'jobs.apply' : 'tenders.apply', $listing) }}" enctype="multipart/form-data" class="mt-6 space-y-5">
    @csrf
    <label class="form-field">
        <span>الاسم الكامل</span>
        <input name="name" value="{{ old('name') }}" required>
        @error('name')<small>{{ $message }}</small>@enderror
    </label>
    <label class="form-field">
        <span>البريد الإلكتروني</span>
        <input type="email" name="email" value="{{ old('email') }}" required>
        @error('email')<small>{{ $message }}</small>@enderror
    </label>
    <label class="form-field">
        <span>رقم الهاتف</span>
        <input name="phone" value="{{ old('phone') }}">
        @error('phone')<small>{{ $message }}</small>@enderror
    </label>

    @foreach ($listing->form_fields ?? [] as $field)
        @php
            $key = $field['key'] ?? '';
            $type = $field['type'] ?? 'text';
            $label = $field['label'] ?? $key;
            $name = $type === 'file' ? "files[{$key}]" : "answers[{$key}]";
            $errorKey = $type === 'file' ? "files.{$key}" : "answers.{$key}";
        @endphp
        <label class="form-field">
            <span>{{ $label }} @if ($field['required'] ?? false)<b>*</b>@endif</span>
            @if ($type === 'textarea')
                <textarea name="{{ $name }}" rows="4">{{ old("answers.{$key}") }}</textarea>
            @elseif ($type === 'select')
                <select name="{{ $name }}">
                    <option value="">اختر</option>
                    @foreach ($field['options'] ?? [] as $option)
                        <option value="{{ $option['value'] ?? '' }}" @selected(old("answers.{$key}") === ($option['value'] ?? ''))>{{ $option['label'] ?? $option['value'] ?? '' }}</option>
                    @endforeach
                </select>
            @elseif ($type === 'checkbox')
                <span class="flex items-center gap-3 rounded-md border border-alisary-green/20 px-4 py-3">
                    <input type="checkbox" name="{{ $name }}" value="1" @checked(old("answers.{$key}")) class="size-5">
                    <span>أوافق</span>
                </span>
            @elseif ($type === 'file')
                <input type="file" name="{{ $name }}">
            @else
                <input type="{{ in_array($type, ['email', 'number', 'date'], true) ? $type : 'text' }}" name="{{ $name }}" value="{{ old("answers.{$key}") }}">
            @endif
            @error($errorKey)<small>{{ $message }}</small>@enderror
        </label>
    @endforeach

    <button class="w-full rounded-md bg-alisary-green px-6 py-4 font-bold text-white transition hover:bg-alisary-deep">إرسال الطلب</button>
</form>
