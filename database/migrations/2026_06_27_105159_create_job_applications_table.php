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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique()->index();
            $table->string('status')->default('new')->index();

            // Section 1: Basic Info
            $table->string('full_name');
            $table->string('phone', 50);
            $table->string('email');
            $table->string('nationality')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();

            // Section 2: Job & Institution
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->string('job_priority_1')->nullable();
            $table->string('job_priority_2')->nullable();
            $table->string('job_priority_3')->nullable();
            $table->json('contract_types')->nullable();
            $table->date('ready_date')->nullable();
            $table->string('expected_salary')->nullable();

            // Section 3: Experience & Tools
            $table->unsignedSmallInteger('years_experience')->nullable();
            $table->boolean('previously_worked')->default(false);
            $table->string('previously_worked_where')->nullable();
            $table->text('tools_and_ai')->nullable();
            $table->string('cv_link')->nullable();
            $table->string('cv_path')->nullable();

            // Section 4: Competency
            $table->text('q_automate')->nullable();
            $table->text('q_learn')->nullable();
            $table->text('q_own')->nullable();

            // Section 5: Situational
            $table->text('q_brand')->nullable();
            $table->text('q_ethics')->nullable();
            $table->text('q_mission')->nullable();

            // Section 6: Future
            $table->text('future_aspirations')->nullable();
            $table->text('q_build')->nullable();
            $table->text('extra_notes')->nullable();

            // Section 7: Consents
            $table->boolean('consent_accurate')->default(false);
            $table->boolean('consent_ai')->default(false);
            $table->boolean('consent_pool')->default(false);
            $table->boolean('consent_transfer')->default(false);

            // Internal
            $table->text('internal_notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
