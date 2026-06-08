<?php

namespace App\Support;

use App\Enums\CustomFieldType;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class CustomFormFields
{
    /**
     * @param  array<int, array<string, mixed>>  $steps
     * @return array<int, array<string, mixed>>
     */
    public static function flattenSteps(array $steps): array
    {
        return collect($steps)
            ->flatMap(fn (mixed $step): array => is_array($step) ? ($step['fields'] ?? []) : [])
            ->filter(fn (mixed $field): bool => is_array($field) && filled($field['key'] ?? null))
            ->values()
            ->all();
    }

    /**
     * @param  array<int, array<string, mixed>>  $fields
     * @return array<int, array<string, mixed>>
     */
    public static function flattenFields(array $fields): array
    {
        if (collect($fields)->contains(fn (mixed $field): bool => is_array($field) && array_key_exists('fields', $field))) {
            return self::flattenSteps($fields);
        }

        return collect($fields)
            ->filter(fn (mixed $field): bool => is_array($field) && filled($field['key'] ?? null))
            ->values()
            ->all();
    }

    /**
     * @param  array<int, array<string, mixed>>  $fields
     * @return array<int, array<string, mixed>>
     */
    public static function sections(array $fields): array
    {
        if (collect($fields)->contains(fn (mixed $field): bool => is_array($field) && array_key_exists('fields', $field))) {
            return collect($fields)
                ->filter(fn (mixed $section): bool => is_array($section))
                ->map(fn (array $section): array => [
                    'title' => $section['title'] ?? null,
                    'description' => $section['description'] ?? null,
                    'fields' => collect($section['fields'] ?? [])
                        ->filter(fn (mixed $field): bool => is_array($field) && filled($field['key'] ?? null))
                        ->values()
                        ->all(),
                ])
                ->filter(fn (array $section): bool => count($section['fields']) > 0)
                ->values()
                ->all();
        }

        $flatFields = self::flattenFields($fields);

        return count($flatFields) > 0
            ? [[
                'title' => 'أسئلة إضافية',
                'description' => null,
                'fields' => $flatFields,
            ]]
            : [];
    }

    /**
     * @param  array<int, array<string, mixed>>  $fields
     * @return array<string, array<int, mixed>>
     */
    public static function validationRules(array $fields): array
    {
        $rules = [
            'answers' => ['array'],
            'files' => ['array'],
        ];

        foreach ($fields as $field) {
            $key = $field['key'] ?? null;
            $type = $field['type'] ?? null;

            if (! is_string($key) || ! is_string($type)) {
                continue;
            }

            $target = $type === CustomFieldType::File->value ? "files.{$key}" : "answers.{$key}";
            $fieldRules = ($field['required'] ?? false) ? ['required'] : ['nullable'];

            if ($type === CustomFieldType::CheckboxList->value) {
                $rules[$target] = [
                    ...$fieldRules,
                    'array',
                    ...(($field['required'] ?? false) ? ['min:1'] : []),
                ];
                $rules["{$target}.*"] = [
                    'string',
                    Rule::in(collect($field['options'] ?? [])->pluck('value')->filter()->values()->all()),
                ];

                continue;
            }

            $rules[$target] = [
                ...$fieldRules,
                ...self::rulesForType($type, $field),
            ];
        }

        return $rules;
    }

    /**
     * @param  array<string, mixed>  $field
     * @return array<int, mixed>
     */
    public static function rulesForType(string $type, array $field): array
    {
        return match ($type) {
            CustomFieldType::Email->value => ['email', 'max:255'],
            CustomFieldType::Phone->value => ['string', 'max:50'],
            CustomFieldType::Number->value => ['numeric'],
            CustomFieldType::Date->value => ['date'],
            CustomFieldType::Textarea->value => ['string', 'max:5000'],
            CustomFieldType::Select->value => [
                'string',
                Rule::in(collect($field['options'] ?? [])->pluck('value')->filter()->values()->all()),
            ],
            CustomFieldType::Checkbox->value => ['accepted'],
            CustomFieldType::File->value => [
                File::types($field['accepted_file_types'] ?? ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'])
                    ->max((int) ($field['max_file_size_kb'] ?? 5120)),
            ],
            default => ['string', 'max:255'],
        };
    }

    /**
     * @return array<string, string>
     */
    public static function storeFiles(Request $request, string $directory): array
    {
        $storedFiles = [];

        foreach ($request->file('files', []) as $key => $file) {
            if (! $file instanceof UploadedFile) {
                continue;
            }

            $storedFiles[$key] = $file->store($directory, 'public');
        }

        return $storedFiles;
    }
}
