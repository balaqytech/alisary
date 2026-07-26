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
        Schema::table('job_applications', function (Blueprint $table) {
            $table->string('phone_country_code', 8)->default('+968')->after('phone');
            $table->string('gender', 10)->nullable()->after('email');
            $table->text('q_compelling_reason')->nullable()->after('q_sample_leadership');
            $table->uuid('submission_token')->nullable()->unique()->after('reference_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropUnique(['submission_token']);
            $table->dropColumn(['phone_country_code', 'gender', 'q_compelling_reason', 'submission_token']);
        });
    }
};
