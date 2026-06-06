@php
    $key = $field['key'] ?? '';
    $type = $field['type'] ?? 'text';
    $label = $field['label'] ?? $key;
    $name = $type === 'file' ? "files[{$key}]" : "answers[{$key}]";
    $errorKey = $type === 'file' ? "files.{$key}" : "answers.{$key}";
    $accepted = collect($field['accepted_file_types'] ?? [])->map(fn ($extension) => '.'.$extension)->implode(',');
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
        <span class="relative flex min-h-28 flex-col items-center justify-center gap-2 rounded-md border border-dashed border-alisary-green/25 bg-alisary-muted/40 px-4 py-5 text-center text-alisary-soft">
            <x-icons.remix.upload-cloud class="size-7 text-alisary-gold" />
            <input type="file" name="{{ $name }}" @if ($accepted) accept="{{ $accepted }}" @endif class="absolute inset-0 cursor-pointer opacity-0">
            <span>رفع ملف</span>
        </span>
    @else
        <input type="{{ in_array($type, ['email', 'number', 'date'], true) ? $type : 'text' }}" name="{{ $name }}" value="{{ old("answers.{$key}") }}">
    @endif
    @error($errorKey)<small>{{ $message }}</small>@enderror
</label>
