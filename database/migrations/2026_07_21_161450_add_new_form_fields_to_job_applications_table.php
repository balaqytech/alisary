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
            $table->string('form_version')->default('v1')->after('status')->index();
            $table->string('track')->nullable()->after('job_priority_3');
            $table->string('previous_institution')->nullable()->after('previously_worked_where');
            $table->string('previous_role')->nullable()->after('previous_institution');
            $table->string('previous_period')->nullable()->after('previous_role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropColumn(['form_version', 'track', 'previous_institution', 'previous_role', 'previous_period']);
        });
    }
};
