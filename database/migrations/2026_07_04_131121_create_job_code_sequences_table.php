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
        Schema::create('job_code_sequences', function (Blueprint $table) {
            $table->id();
            $table->string('group_prefix', 16);
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('job_family_id')->constrained()->cascadeOnDelete();
            $table->string('job_level', 8);
            $table->unsignedSmallInteger('year');
            $table->unsignedInteger('next_number')->default(1);
            $table->timestamps();

            $table->unique([
                'group_prefix',
                'company_id',
                'job_family_id',
                'job_level',
                'year',
            ], 'job_code_sequences_scope_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_code_sequences');
    }
};
