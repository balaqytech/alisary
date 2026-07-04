<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('job_listings', 'job_code')) {
            Schema::table('job_listings', function (Blueprint $table) {
                $table->string('job_code', 64)->nullable()->after('id');
            });
        }

        if (! Schema::hasColumn('job_listings', 'job_family_id')) {
            Schema::table('job_listings', function (Blueprint $table) {
                $table->foreignId('job_family_id')->nullable()->after('company_id');
            });
        }

        if (! Schema::hasColumn('job_listings', 'job_level')) {
            Schema::table('job_listings', function (Blueprint $table) {
                $table->string('job_level', 8)->nullable()->after('job_family_id')->index();
            });
        }

        if (! Schema::hasColumn('job_listings', 'job_code_year')) {
            Schema::table('job_listings', function (Blueprint $table) {
                $table->unsignedSmallInteger('job_code_year')->nullable()->after('job_level')->index();
            });
        }

        if (! Schema::hasColumn('job_listings', 'job_code_sequence')) {
            Schema::table('job_listings', function (Blueprint $table) {
                $table->unsignedInteger('job_code_sequence')->nullable()->after('job_code_year');
            });
        }

        Schema::table('job_listings', function (Blueprint $table) {
            $table->unique('job_code');
            $table->foreign('job_family_id')->references('id')->on('job_families')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('job_family_id');
            $table->dropUnique(['job_code']);
            $table->dropColumn([
                'job_code',
                'job_level',
                'job_code_year',
                'job_code_sequence',
            ]);
        });
    }
};
