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
            $table->text('q_achievement')->nullable()->after('track');
            $table->text('q_sample_teaching')->nullable()->after('q_achievement');
            $table->text('q_sample_operations')->nullable()->after('q_sample_teaching');
            $table->text('q_sample_leadership')->nullable()->after('q_sample_operations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropColumn(['q_achievement', 'q_sample_teaching', 'q_sample_operations', 'q_sample_leadership']);
        });
    }
};
