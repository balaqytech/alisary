<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('job_listings')
            ->select(['id', 'form_fields'])
            ->whereNotNull('form_fields')
            ->orderBy('id')
            ->get()
            ->each(function (object $jobListing): void {
                $fields = json_decode($jobListing->form_fields, true);

                if (! is_array($fields) || $fields === [] || $this->hasSections($fields)) {
                    return;
                }

                DB::table('job_listings')
                    ->where('id', $jobListing->id)
                    ->update([
                        'form_fields' => json_encode([
                            [
                                'title' => 'أسئلة إضافية',
                                'description' => null,
                                'fields' => $fields,
                            ],
                        ], JSON_UNESCAPED_UNICODE),
                    ]);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('job_listings')
            ->select(['id', 'form_fields'])
            ->whereNotNull('form_fields')
            ->orderBy('id')
            ->get()
            ->each(function (object $jobListing): void {
                $sections = json_decode($jobListing->form_fields, true);

                if (! is_array($sections) || count($sections) !== 1) {
                    return;
                }

                $section = $sections[0];

                if (($section['title'] ?? null) !== 'أسئلة إضافية' || ! is_array($section['fields'] ?? null)) {
                    return;
                }

                DB::table('job_listings')
                    ->where('id', $jobListing->id)
                    ->update([
                        'form_fields' => json_encode($section['fields'], JSON_UNESCAPED_UNICODE),
                    ]);
            });
    }

    /**
     * @param  array<int, mixed>  $fields
     */
    private function hasSections(array $fields): bool
    {
        return collect($fields)->contains(fn (mixed $field): bool => is_array($field) && array_key_exists('fields', $field));
    }
};
