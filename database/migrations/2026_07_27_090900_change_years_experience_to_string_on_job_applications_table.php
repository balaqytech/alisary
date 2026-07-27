<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->string('years_experience', 20)->nullable()->change();
        });
    }

    public function down(): void
    {
        $numericValues = [
            '1-3' => 1,
            '4-7' => 4,
            '8-10' => 8,
            '10+' => 11,
        ];

        foreach ($numericValues as $range => $years) {
            DB::table('job_applications')
                ->where('years_experience', $range)
                ->update(['years_experience' => $years]);
        }

        Schema::table('job_applications', function (Blueprint $table) {
            $table->unsignedSmallInteger('years_experience')->nullable()->change();
        });
    }
};
