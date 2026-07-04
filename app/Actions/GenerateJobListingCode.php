<?php

namespace App\Actions;

use App\Models\Company;
use App\Models\JobFamily;
use App\Models\JobListing;
use BackedEnum;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class GenerateJobListingCode
{
    /**
     * Generate and reserve the next immutable reference code for a vacancy.
     */
    public function handle(JobListing $jobListing): string
    {
        $groupPrefix = config('job_references.group_prefix');
        $year = now()->year;

        if (! is_string($groupPrefix) || $groupPrefix === '') {
            throw new RuntimeException('Job reference group prefix is not configured.');
        }

        $jobLevel = $jobListing->job_level instanceof BackedEnum
            ? $jobListing->job_level->value
            : $jobListing->job_level;

        if ($jobListing->company_id === null || $jobListing->job_family_id === null || $jobLevel === null) {
            throw new RuntimeException('A company, job family, and job level are required to generate a job reference code.');
        }

        $companyCode = Company::query()->whereKey($jobListing->company_id)->value('reference_code');
        $jobFamilyCode = JobFamily::query()->whereKey($jobListing->job_family_id)->value('code');

        if (! is_string($companyCode) || $companyCode === '') {
            throw new RuntimeException('The selected company does not have a reference code.');
        }

        if (! is_string($jobFamilyCode) || $jobFamilyCode === '') {
            throw new RuntimeException('The selected job family does not have a reference code.');
        }

        $sequence = DB::transaction(function () use ($groupPrefix, $jobLevel, $jobListing, $year): int {
            $scope = [
                'group_prefix' => $groupPrefix,
                'company_id' => $jobListing->company_id,
                'job_family_id' => $jobListing->job_family_id,
                'job_level' => $jobLevel,
                'year' => $year,
            ];

            DB::table('job_code_sequences')->insertOrIgnore([
                ...$scope,
                'next_number' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $sequenceRow = DB::table('job_code_sequences')
                ->where($scope)
                ->lockForUpdate()
                ->first();

            if ($sequenceRow === null) {
                throw new RuntimeException('Unable to reserve the next job reference sequence.');
            }

            DB::table('job_code_sequences')
                ->where('id', $sequenceRow->id)
                ->update([
                    'next_number' => $sequenceRow->next_number + 1,
                    'updated_at' => now(),
                ]);

            return (int) $sequenceRow->next_number;
        }, attempts: 5);

        $jobListing->job_code_year = $year;
        $jobListing->job_code_sequence = $sequence;

        return implode('-', [
            $groupPrefix,
            $companyCode,
            $jobFamilyCode,
            $jobLevel,
            (string) $year,
            str_pad((string) $sequence, (int) config('job_references.sequence_padding', 3), '0', STR_PAD_LEFT),
        ]);
    }
}
