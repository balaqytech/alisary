@php
    $key = $field['key'] ?? '';
    $type = $field['type'] ?? 'text';
    $label = $field['label'] ?? $key;
    $name = $type === 'file' ? "files[{$key}]" : "answers[{$key}]";
    $errorKey = $type === 'file' ? "files.{$key}" : "answers.{$key}";
    $accepted = collect($field['accepted_file_types'] ?? [])->map(fn ($extension) => '.'.$extension)->implode(',');
    $oldValues = collect(old("answers.{$key}", []))->filter()->values();
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
    @elseif ($type === 'checkbox_list')
        <span class="choice-grid">
            @foreach ($field['options'] ?? [] as $option)
                @php($value = $option['value'] ?? '')
                <span class="choice-pill">
                    <input type="checkbox" name="{{ $name }}[]" value="{{ $value }}" @checked($oldValues->containsStrict($value))>
                    <span>{{ $option['label'] ?? $value }}</span>
                </span>
            @endforeach
        </span>
    @elseif ($type === 'file')
        <span class="application-upload">
            <x-icons.remix.upload-cloud class="size-7 text-alisary-gold" />
            <input type="file" name="{{ $name }}" @if ($accepted) accept="{{ $accepted }}" @endif>
            <span>رفع ملف</span>
        </span>
    @else
        <input type="{{ in_array($type, ['email', 'number', 'date'], true) ? $type : 'text' }}" name="{{ $name }}" value="{{ old("answers.{$key}") }}">
    @endif
    @error($errorKey)<small>{{ $message }}</small>@enderror
</label>
